<?php

class WebhookLogger {
    private static $table_name;
    private const MAX_RETRIES = 5;
    private const RETRY_INTERVAL = 60;
    private const WEBHOOK_URL = 'https://webhook.site/b99936e3-c362-4f85-8534-db1748557b46';

    public static function init() {
        global $wpdb;
        self::$table_name = $wpdb->prefix . 'webhook_logs';
        self::create_table();
        self::register_hooks();
    }

    private static function create_table(): void {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS " . self::$table_name . " (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
            action VARCHAR(50) NOT NULL,
            user_id BIGINT(20) UNSIGNED,
            webhook_url VARCHAR(255),
            request_payload LONGTEXT,
            response_code INT,
            response_body LONGTEXT,
            retry_count TINYINT UNSIGNED DEFAULT 0,
            status VARCHAR(20),
            message TEXT,
            INDEX user_id (user_id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    private static function log_event(array $data): void {
        global $wpdb;
        $format = ['%s', '%d', '%s', '%s', '%d', '%s', '%d', '%s', '%s'];
        $wpdb->insert(self::$table_name, $data, $format);
    }

    private static function send_webhook(int $user_id, string $action): void {
        $retry_count = 0;
        $user_data = get_userdata($user_id);

        if (!$user_data) {
            self::log_error("User not found: $user_id", $action, $user_id);
            return;
        }

        $payload = self::prepare_payload($user_data, $action);
        $args = self::prepare_request_args($payload);

        while ($retry_count < self::MAX_RETRIES) {
            $response = wp_remote_post(self::WEBHOOK_URL, $args);

            if (is_wp_error($response)) {
                self::handle_error($response, $action, $user_id, $payload, $retry_count);
            } else {
                $success = self::handle_response($response, $action, $user_id, $payload, $retry_count);
                if ($success) break;
            }

            $retry_count++;
            if ($retry_count < self::MAX_RETRIES) {
                sleep(self::RETRY_INTERVAL);
            } else {
                self::log_error("Webhook failed after " . self::MAX_RETRIES . " retries.", $action, $user_id, $payload);
            }
        }
    }

    private static function prepare_payload($user_data, $action): array {
        return [
            'action' => $action,
            'user' => [
                'ID' => $user_data->ID,
                'user_login' => $user_data->user_login,
                'user_email' => $user_data->user_email,
                'display_name' => $user_data->display_name,
                'roles' => $user_data->roles,
                'registered' => $user_data->user_registered,
                'first_name' => $user_data->first_name,
                'last_name' => $user_data->last_name,
                'description' => $user_data->description,
            ],
        ];
    }

    private static function prepare_request_args($payload): array {
        return [
            'method' => 'POST',
            'headers' => ['Content-Type: application/json'],
            'body' => wp_json_encode($payload),
            'timeout' => 10,
        ];
    }

    private static function handle_response($response, $action, $user_id, $payload, $retry_count): bool {
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        if ($response_code >= 200 && $response_code < 300) {
            error_log("Webhook gửi thành công ($action) - Response Code: $response_code, Body: $response_body");
            self::log_event([
                'action' => $action,
                'user_id' => $user_id,
                'webhook_url' => self::WEBHOOK_URL,
                'request_payload' => wp_json_encode($payload),
                'response_code' => $response_code,
                'response_body' => $response_body,
                'retry_count' => $retry_count,
                'status' => 'success',
                'message' => "Webhook gửi thành công - Response Code: $response_code"
            ]);
            return true;
        } else {
            error_log("Webhook gửi không thành công ($action) - Response Code: $response_code, Body: $response_body");
            self::log_event([
                'action' => $action,
                'user_id' => $user_id,
                'webhook_url' => self::WEBHOOK_URL,
                'request_payload' => wp_json_encode($payload),
                'response_code' => $response_code,
                'response_body' => $response_body,
                'retry_count' => $retry_count + 1, // Log cho lần thử tiếp theo
                'status' => 'failed',
                'message' => "Webhook gửi không thành công - Response Code: $response_code"
            ]);
            return false;
        }
    }

    private static function handle_error($response, $action, $user_id, $payload, $retry_count): void {
        $error_message = $response->get_error_message();
        error_log("Lỗi gửi webhook ($action) lần " . ($retry_count + 1) . ": " . $error_message);
        self::log_event([
            'action' => $action,
            'user_id' => $user_id,
            'webhook_url' => self::WEBHOOK_URL,
            'request_payload' => wp_json_encode($payload),
            'retry_count' => $retry_count + 1, // Log cho lần thử tiếp theo
            'status' => 'failed',
            'message' => "Lỗi gửi webhook lần " . ($retry_count + 1) . ": " . $error_message
        ]);
    }

    private static function register_hooks(): void {
        add_action('user_register', [self::class, 'handle_user_created']);
        add_action('profile_update', [self::class, 'handle_user_updated'], 10, 3); // Quan trọng: Thêm số lượng tham số mong đợi
        add_action('delete_user', [self::class, 'handle_user_deleted']);
    }

    // Hook handlers
    public static function handle_user_created($user_id) {
        self::send_webhook($user_id, 'created');
    }

    public static function handle_user_updated($user_id, $old_user_data, $userdata) {
        self::send_webhook($user_id, 'updated');
    }

    public static function handle_user_deleted($user_id) {
        self::send_webhook($user_id, 'deleted');
    }

    private static function log_error($message, $action, $user_id, $payload = null): void {
        error_log($message);
        self::log_event([
            'action' => $action,
            'user_id' => $user_id,
            'webhook_url' => self::WEBHOOK_URL,
            'request_payload' => wp_json_encode($payload),
            'status' => 'failed',
            'message' => $message
        ]);
    }
}

// Initialize the webhook logger
add_action('init', ['WebhookLogger', 'init']);
