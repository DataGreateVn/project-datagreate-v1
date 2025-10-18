<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translation;

class TranslationAdminSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $ns = 'admin';
        $gr = 'settings';

        $rows = [
            // ===== VI =====
            ['vi', $ns, $gr, 'page_title', 'Cấu hình'],
            ['vi', $ns, $gr, 'page_heading', 'Tổng quan'],
            ['vi', $ns, $gr, 'group.info', 'Cài đặt thông tin'],
            ['vi', $ns, $gr, 'group.email', 'Email'],
            ['vi', $ns, $gr, 'group.content', 'Nội dung'],
            ['vi', $ns, $gr, 'sidebar.general', 'Thông tin chung'],
            ['vi', $ns, $gr, 'sidebar.meta', 'Meta'],
            ['vi', $ns, $gr, 'sidebar.robots', 'Robots.txt'],
            ['vi', $ns, $gr, 'sidebar.redirects', 'Redirects'],
            ['vi', $ns, $gr, 'sidebar.env', 'Tuỳ chỉnh biến môi trường'],
            ['vi', $ns, $gr, 'sidebar.smtp', 'Cấu hình SMTP'],
            ['vi', $ns, $gr, 'sidebar.notifications', 'Thông báo'],
            ['vi', $ns, $gr, 'sidebar.translations', 'Translations (i18n)'],
            ['vi', $ns, $gr, 'actions.save', 'Lưu'],
            ['vi', $ns, $gr, 'actions.clear_cache', 'Xoá cache'],
            ['vi', $ns, $gr, 'blank.no_content', 'Chưa có nội dung cho mục này.'],
            ['vi', $ns, $gr, 'env.title', 'Tuỳ chỉnh biến môi trường'],
            ['vi', $ns, $gr, 'env.hint', 'Bạn có thể thêm UI ghi .env nếu muốn (cân nhắc permissions & bảo mật).'],
            ['vi', $ns, $gr, 'general.company_name', 'Tên Doanh Nghiệp'],
            ['vi', $ns, $gr, 'general.site_name', 'Tên Website'],
            ['vi', $ns, $gr, 'general.email', 'Email Liên Hệ'],
            ['vi', $ns, $gr, 'general.phone', 'Phone'],
            ['vi', $ns, $gr, 'general.facebook', 'Fb Link'],
            ['vi', $ns, $gr, 'general.fb_message', 'Fb Message Link'],
            ['vi', $ns, $gr, 'general.instagram', 'Instagram Link'],
            ['vi', $ns, $gr, 'general.youtube', 'Youtube Link'],
            ['vi', $ns, $gr, 'general.linkedin', 'LinkedIn Link'],
            ['vi', $ns, $gr, 'general.zalo', 'Zalo Link'],
            ['vi', $ns, $gr, 'meta.default_title', 'Default SEO Title'],
            ['vi', $ns, $gr, 'meta.default_desc', 'Default Meta Description'],
            ['vi', $ns, $gr, 'meta.recommend', 'Khuyến nghị 120–160 ký tự.'],
            ['vi', $ns, $gr, 'notifications.title', 'Thông báo'],
            ['vi', $ns, $gr, 'notifications.hint', 'Thêm cấu hình mail template / webhook (Slack, Telegram…) nếu cần.'],
            ['vi', $ns, $gr, 'redirects.hint', 'JSON: [{"from":"/old","to":"/new","code":301}]'],
            ['vi', $ns, $gr, 'smtp.title', 'Cấu hình SMTP'],
            ['vi', $ns, $gr, 'smtp.hint_password', 'Để trống để giữ mật khẩu hiện tại.'],
            ['vi', $ns, $gr, 'i18n.open_full', 'Mở trang quản lý đầy đủ'],
            ['vi', $ns, $gr, 'i18n.clear_cache', 'Clear i18n cache'],
            ['vi', $ns, $gr, 'i18n.default_locale', 'Default locale'],
            ['vi', $ns, $gr, 'i18n.namespaces', 'Namespaces được phép'],
            ['vi', $ns, $gr, 'i18n.namespaces_hint', 'VD: *,site,admin'],

            // ===== EN =====
            ['en', $ns, $gr, 'page_title', 'Settings'],
            ['en', $ns, $gr, 'page_heading', 'General'],
            ['en', $ns, $gr, 'group.info', 'Information'],
            ['en', $ns, $gr, 'group.email', 'Email'],
            ['en', $ns, $gr, 'group.content', 'Content'],
            ['en', $ns, $gr, 'sidebar.general', 'General'],
            ['en', $ns, $gr, 'sidebar.meta', 'Meta'],
            ['en', $ns, $gr, 'sidebar.robots', 'Robots.txt'],
            ['en', $ns, $gr, 'sidebar.redirects', 'Redirects'],
            ['en', $ns, $gr, 'sidebar.env', 'Environment'],
            ['en', $ns, $gr, 'sidebar.smtp', 'SMTP'],
            ['en', $ns, $gr, 'sidebar.notifications', 'Notifications'],
            ['en', $ns, $gr, 'sidebar.translations', 'Translations (i18n)'],
            ['en', $ns, $gr, 'actions.save', 'Save'],
            ['en', $ns, $gr, 'actions.clear_cache', 'Clear cache'],
            ['en', $ns, $gr, 'blank.no_content', 'No content for this section.'],
            ['en', $ns, $gr, 'env.title', 'Environment variables'],
            ['en', $ns, $gr, 'env.hint', 'You may add a UI to write .env (mind permissions & security).'],
            ['en', $ns, $gr, 'general.company_name', 'Company Name'],
            ['en', $ns, $gr, 'general.site_name', 'Site Name'],
            ['en', $ns, $gr, 'general.email', 'Contact Email'],
            ['en', $ns, $gr, 'general.phone', 'Phone'],
            ['en', $ns, $gr, 'general.facebook', 'Facebook Link'],
            ['en', $ns, $gr, 'general.fb_message', 'Facebook Message Link'],
            ['en', $ns, $gr, 'general.instagram', 'Instagram Link'],
            ['en', $ns, $gr, 'general.youtube', 'YouTube Link'],
            ['en', $ns, $gr, 'general.linkedin', 'LinkedIn Link'],
            ['en', $ns, $gr, 'general.zalo', 'Zalo Link'],
            ['en', $ns, $gr, 'meta.default_title', 'Default SEO Title'],
            ['en', $ns, $gr, 'meta.default_desc', 'Default Meta Description'],
            ['en', $ns, $gr, 'meta.recommend', 'Recommended 120–160 characters.'],
            ['en', $ns, $gr, 'notifications.title', 'Notifications'],
            ['en', $ns, $gr, 'notifications.hint', 'Add mail templates / webhooks (Slack, Telegram…) if needed.'],
            ['en', $ns, $gr, 'redirects.hint', 'JSON: [{"from":"/old","to":"/new","code":301}]'],
            ['en', $ns, $gr, 'smtp.title', 'SMTP Settings'],
            ['en', $ns, $gr, 'smtp.hint_password', 'Leave blank to keep current password.'],
            ['en', $ns, $gr, 'i18n.open_full', 'Open full management'],
            ['en', $ns, $gr, 'i18n.clear_cache', 'Clear i18n cache'],
            ['en', $ns, $gr, 'i18n.default_locale', 'Default locale'],
            ['en', $ns, $gr, 'i18n.namespaces', 'Allowed namespaces'],
            ['en', $ns, $gr, 'i18n.namespaces_hint', 'E.g.: *,site,admin'],

            // ===== BREADCRUMBS =====
            ['vi', 'admin', 'breadcrumbs', 'home', 'Trang chủ'],
            ['vi', 'admin', 'breadcrumbs', 'dashboard', 'Bảng điều khiển'],
            ['vi', 'admin', 'breadcrumbs', 'settings', 'Cấu hình'],
            ['vi', 'admin', 'breadcrumbs', 'translations', 'Dịch'],
            ['vi', 'admin', 'breadcrumbs', 'create', 'Thêm mới'],
            ['vi', 'admin', 'breadcrumbs', 'edit', 'Chỉnh sửa'],
            ['vi', 'admin', 'breadcrumbs', 'section', 'Mục'],


            ['en', 'admin', 'breadcrumbs', 'home', 'Home'],
            ['en', 'admin', 'breadcrumbs', 'dashboard', 'Dashboard'],
            ['en', 'admin', 'breadcrumbs', 'settings', 'Settings'],
            ['en', 'admin', 'breadcrumbs', 'translations', 'Translations'],
            ['en', 'admin', 'breadcrumbs', 'create', 'Create'],
            ['en', 'admin', 'breadcrumbs', 'edit', 'Edit'],
            ['en', 'admin', 'breadcrumbs', 'section', 'Section'],
        ];

        foreach ($rows as [$locale, $namespace, $group, $key, $value]) {
            Translation::updateOrCreate(
                ['locale' => $locale, 'namespace' => $namespace, 'group' => $group, 'key' => $key],
                ['value' => $value, 'updated_by' => 1]
            );
        }
    }
}
