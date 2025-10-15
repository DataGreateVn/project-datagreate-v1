<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translation;

class AdminUiTranslationsSeeder extends Seeder
{
    /**
     * Upsert 1 bản dịch theo composite key.
     */
    protected function put(string $locale, string $namespace, string $group, string $key, string $value, ?int $updatedBy = null): void
    {
        Translation::updateOrCreate(
            compact('locale', 'namespace', 'group', 'key'),
            ['value' => $value, 'updated_by' => $updatedBy],
        );
    }

    /**
     * Upsert nhiều key trong 1 group/namespace.
     */
    protected function putMany(string $locale, string $namespace, string $group, array $pairs, ?int $updatedBy = null): void
    {
        foreach ($pairs as $key => $value) {
            $this->put($locale, $namespace, $group, $key, $value, $updatedBy);
        }
    }

    public function run(): void
    {
        $ns = 'admin';

        /** =========================
         * VIETNAMESE (vi)
         * =======================*/
        // Breadcrumb
        $this->putMany('vi', $ns, 'breadcrumb', [
            'home'      => 'Trang chủ',
            'settings'  => 'Cấu hình',
            'section'   => 'Phần',
            'list'      => 'Danh sách',
            'create'    => 'Tạo mới',
            'edit'      => 'Chỉnh sửa',
        ]);

        // Sidebar / Menu
        $this->putMany('vi', $ns, 'sidebar', [
            'dashboard'     => 'Bảng điều khiển',
            'settings'      => 'Cài đặt',
            'translations'  => 'Bản dịch',
            'general'       => 'Thông tin chung',
            'meta'          => 'Meta',
            'robots'        => 'Robots.txt',
            'redirects'     => 'Redirects',
            'env'           => 'Biến môi trường',
            'email'         => 'Email',
            'smtp'          => 'Cấu hình SMTP',
            'notify'        => 'Thông báo',
            'content'       => 'Nội dung',
            'i18n'          => 'Translations (i18n)',
        ]);

        // Layout topbar/footer
        $this->putMany('vi', $ns, 'layout', [
            'skip_nav'          => 'Bỏ qua điều hướng',
            'change_password'   => 'Đổi mật khẩu',
            'logout_title'      => 'Đăng xuất',
            'search_placeholder' => 'Tìm kiếm...',
            'language_vi'       => 'Tiếng Việt',
            'language_en'       => 'English',
        ]);

        // Common actions / buttons / table headers
        $this->putMany('vi', $ns, 'common', [
            'create'    => 'Tạo mới',
            'save'      => 'Lưu',
            'save_new'  => 'Lưu & Tạo tiếp',
            'update'    => 'Cập nhật',
            'cancel'    => 'Hủy',
            'back'      => 'Quay lại',
            'search'    => 'Tìm kiếm',
            'reset'     => 'Đặt lại',
            'edit'      => 'Sửa',
            'delete'    => 'Xóa',
            'copied'    => 'Đã sao chép!',
            'copy'      => 'Sao chép',
            'show_more' => 'Xem thêm',
            'show_less' => 'Thu gọn',
            'no_data'   => 'Không có dữ liệu',
            'actions'   => 'Thao tác',
        ]);

        // Settings sections
        $this->putMany('vi', $ns, 'settings_sections', [
            'title'                     => 'Cấu hình',
            'general'                   => 'Thông tin chung',
            'meta'                      => 'Meta',
            'robots'                    => 'Robots.txt',
            'redirects'                 => 'Redirects',
            'env'                       => 'Tuỳ chỉnh biến môi trường',
            'smtp'                      => 'Cấu hình SMTP',
            'i18n'                      => 'Translations (i18n)',
            'open_full_manager'         => 'Mở trang quản lý đầy đủ',
            'clear_i18n_cache'          => 'Xoá cache i18n',
            'default_locale'            => 'Ngôn ngữ mặc định',
            'allowed_namespaces'        => 'Namespaces được phép',
            'allowed_namespaces_hint'   => 'VD: *,site,admin',
            'saved_ok'                  => 'Đã lưu',
        ]);

        // Settings: General form fields
        $this->putMany('vi', $ns, 'settings_general', [
            'company_name'  => 'Tên Doanh Nghiệp',
            'site_name'     => 'Tên Website',
            'site_email'    => 'Email Liên Hệ',
            'site_phone'    => 'Số điện thoại',
            'social_facebook'   => 'Link Facebook',
            'social_fb_message' => 'Link Facebook Messenger',
            'social_instagram'  => 'Link Instagram',
            'social_youtube'    => 'Link YouTube',
            'social_linkedin'   => 'Link LinkedIn',
            'social_zalo'       => 'Link Zalo',
            'clear_cache'       => 'Xoá cache',
        ]);

        // Settings: Meta
        $this->putMany('vi', $ns, 'settings_meta', [
            'default_title'         => 'Tiêu đề SEO mặc định',
            'default_description'   => 'Mô tả SEO mặc định',
        ]);

        // Settings: Redirects
        $this->putMany('vi', $ns, 'settings_redirects', [
            'title'     => 'Redirects',
            'help'      => 'JSON: [{"from":"/old","to":"/new","code":301}]',
        ]);

        // Settings: Robots
        $this->putMany('vi', $ns, 'settings_robots', [
            'title' => 'robots.txt',
        ]);

        // Settings: SMTP
        $this->putMany('vi', $ns, 'settings_smtp', [
            'title'         => 'Cấu hình SMTP',
            'mailer'        => 'MAIL_MAILER',
            'host'          => 'MAIL_HOST',
            'port'          => 'MAIL_PORT',
            'username'      => 'MAIL_USERNAME',
            'password'      => 'MAIL_PASSWORD',
            'encryption'    => 'MAIL_ENCRYPTION',
        ]);

        // Translations Index (list)
        $this->putMany('vi', $ns, 'translations_index', [
            'title'         => 'Bản dịch',
            'filters'       => 'Bộ lọc',
            'q_placeholder' => 'Tìm key/value...',
            'locale'        => 'Ngôn ngữ',
            'namespace'     => 'Namespace',
            'group'         => 'Nhóm',
            'per_page'      => '%d/trang',
            'clear_cache'   => 'Xoá cache',
            'reset'         => 'Đặt lại',
            'new'           => 'Tạo mới',
            'table_locale'      => 'Locale',
            'table_namespace'   => 'Namespace',
            'table_group'       => 'Group',
            'table_key'         => 'Key',
            'table_value'       => 'Giá trị',
            'table_actions'     => 'Thao tác',
            'edit'              => 'Sửa',
            'delete'            => 'Xoá',
        ]);

        // Translations Form
        $this->putMany('vi', $ns, 'translations_form', [
            'create_title'      => 'Tạo bản dịch',
            'edit_title'        => 'Sửa bản dịch',
            'back'              => 'Quay lại',
            'meta_section'      => 'Thông tin',
            'value_section'     => 'Giá trị',
            'locale'            => 'Locale',
            'namespace'         => 'Namespace',
            'group'             => 'Group',
            'key'               => 'Key',
            'value'             => 'Value',
            'value_placeholder' => 'Nội dung bản dịch (plain text hoặc JSON string)',
            'tip_json'          => 'Tip: nếu là JSON, đảm bảo cú pháp hợp lệ.',
            'save'              => 'Lưu thay đổi',
            'create'            => 'Tạo mới',
            'save_new'          => 'Lưu & Tạo tiếp',
            'cancel'            => 'Huỷ',
            'hints_title'       => 'Gợi ý',
            'hint_locale'       => 'ví dụ: vi, en',
            'hint_namespace'    => 'để * nếu không dùng',
            'hint_group'        => 'ví dụ: homepage',
            'hint_key'          => 'ví dụ: welcome.title',
        ]);

        // Language labels
        $this->putMany('vi', $ns, 'lang', [
            'vi' => 'Tiếng Việt',
            'en' => 'Tiếng Anh',
        ]);

        /** =========================
         * ENGLISH (en)
         * =======================*/
        // Breadcrumb
        $this->putMany('en', $ns, 'breadcrumb', [
            'home'      => 'Home',
            'settings'  => 'Settings',
            'section'   => 'Section',
            'list'      => 'List',
            'create'    => 'Create',
            'edit'      => 'Edit',
        ]);

        // Sidebar / Menu
        $this->putMany('en', $ns, 'sidebar', [
            'dashboard'     => 'Dashboard',
            'settings'      => 'Settings',
            'translations'  => 'Translations',
            'general'       => 'General',
            'meta'          => 'Meta',
            'robots'        => 'Robots.txt',
            'redirects'     => 'Redirects',
            'env'           => 'Environment',
            'email'         => 'Email',
            'smtp'          => 'SMTP config',
            'notify'        => 'Notifications',
            'content'       => 'Content',
            'i18n'          => 'Translations (i18n)',
        ]);

        // Layout topbar/footer
        $this->putMany('en', $ns, 'layout', [
            'skip_nav'          => 'Skip navigation',
            'change_password'   => 'Change password',
            'logout_title'      => 'Sign out',
            'search_placeholder' => 'Search...',
            'language_vi'       => 'Vietnamese',
            'language_en'       => 'English',
        ]);

        // Common actions / buttons / table headers
        $this->putMany('en', $ns, 'common', [
            'create'    => 'Create',
            'save'      => 'Save',
            'save_new'  => 'Save & New',
            'update'    => 'Update',
            'cancel'    => 'Cancel',
            'back'      => 'Back',
            'search'    => 'Search',
            'reset'     => 'Reset',
            'edit'      => 'Edit',
            'delete'    => 'Delete',
            'copied'    => 'Copied!',
            'copy'      => 'Copy',
            'show_more' => 'Show more',
            'show_less' => 'Show less',
            'no_data'   => 'No data',
            'actions'   => 'Actions',
        ]);

        // Settings sections
        $this->putMany('en', $ns, 'settings_sections', [
            'title'                     => 'Settings',
            'general'                   => 'General',
            'meta'                      => 'Meta',
            'robots'                    => 'Robots.txt',
            'redirects'                 => 'Redirects',
            'env'                       => 'Environment overrides',
            'smtp'                      => 'SMTP config',
            'i18n'                      => 'Translations (i18n)',
            'open_full_manager'         => 'Open full manager',
            'clear_i18n_cache'          => 'Clear i18n cache',
            'default_locale'            => 'Default locale',
            'allowed_namespaces'        => 'Allowed namespaces',
            'allowed_namespaces_hint'   => 'E.g. *,site,admin',
            'saved_ok'                  => 'Saved',
        ]);

        // Settings: General form fields
        $this->putMany('en', $ns, 'settings_general', [
            'company_name'  => 'Company Name',
            'site_name'     => 'Website Name',
            'site_email'    => 'Contact Email',
            'site_phone'    => 'Phone',
            'social_facebook'   => 'Facebook Link',
            'social_fb_message' => 'Facebook Messenger Link',
            'social_instagram'  => 'Instagram Link',
            'social_youtube'    => 'YouTube Link',
            'social_linkedin'   => 'LinkedIn Link',
            'social_zalo'       => 'Zalo Link',
            'clear_cache'       => 'Clear Cache',
        ]);

        // Settings: Meta
        $this->putMany('en', $ns, 'settings_meta', [
            'default_title'         => 'Default SEO Title',
            'default_description'   => 'Default Meta Description',
        ]);

        // Settings: Redirects
        $this->putMany('en', $ns, 'settings_redirects', [
            'title'     => 'Redirects',
            'help'      => 'JSON: [{"from":"/old","to":"/new","code":301}]',
        ]);

        // Settings: Robots
        $this->putMany('en', $ns, 'settings_robots', [
            'title' => 'robots.txt',
        ]);

        // Settings: SMTP
        $this->putMany('en', $ns, 'settings_smtp', [
            'title'         => 'SMTP config',
            'mailer'        => 'MAIL_MAILER',
            'host'          => 'MAIL_HOST',
            'port'          => 'MAIL_PORT',
            'username'      => 'MAIL_USERNAME',
            'password'      => 'MAIL_PASSWORD',
            'encryption'    => 'MAIL_ENCRYPTION',
        ]);

        // Translations Index (list)
        $this->putMany('en', $ns, 'translations_index', [
            'title'         => 'Translations',
            'filters'       => 'Filters',
            'q_placeholder' => 'Search key/value...',
            'locale'        => 'Locale',
            'namespace'     => 'Namespace',
            'group'         => 'Group',
            'per_page'      => '%d/page',
            'clear_cache'   => 'Clear Cache',
            'reset'         => 'Reset',
            'new'           => 'New',
            'table_locale'      => 'Locale',
            'table_namespace'   => 'Namespace',
            'table_group'       => 'Group',
            'table_key'         => 'Key',
            'table_value'       => 'Value',
            'table_actions'     => 'Actions',
            'edit'              => 'Edit',
            'delete'            => 'Delete',
        ]);

        // Translations Form
        $this->putMany('en', $ns, 'translations_form', [
            'create_title'      => 'Create Translation',
            'edit_title'        => 'Edit Translation',
            'back'              => 'Back',
            'meta_section'      => 'Meta',
            'value_section'     => 'Value',
            'locale'            => 'Locale',
            'namespace'         => 'Namespace',
            'group'             => 'Group',
            'key'               => 'Key',
            'value'             => 'Value',
            'value_placeholder' => 'Translation content (plain text or JSON string)',
            'tip_json'          => 'Tip: if JSON, make sure it is valid.',
            'save'              => 'Save changes',
            'create'            => 'Create',
            'save_new'          => 'Save & New',
            'cancel'            => 'Cancel',
            'hints_title'       => 'Hints',
            'hint_locale'       => 'e.g. vi, en',
            'hint_namespace'    => 'use * if none',
            'hint_group'        => 'e.g. homepage',
            'hint_key'          => 'e.g. welcome.title',
        ]);

        // Language labels
        $this->putMany('en', $ns, 'lang', [
            'vi' => 'Vietnamese',
            'en' => 'English',
        ]);
    }
}
