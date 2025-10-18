<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

class TranslationAdminTranslationsSeeder extends Seeder
{
    public function run(): void
    {
        $ns = 'admin';
        $gr = 'translations';

        $rows = [
            // ===== VI =====
            ['vi', $ns, $gr, 'index.title', 'Bản dịch'],
            ['vi', $ns, $gr, 'index.heading', 'Quản lý Bản dịch'],
            ['vi', $ns, $gr, 'index.search_placeholder', 'Tìm kiếm...'],
            ['vi', $ns, $gr, 'index.add_new', 'Thêm mới'],
            ['vi', $ns, $gr, 'index.col_locale', 'Locale'],
            ['vi', $ns, $gr, 'index.col_namespace', 'Namespace'],
            ['vi', $ns, $gr, 'index.col_group', 'Group'],
            ['vi', $ns, $gr, 'index.col_key', 'Key'],
            ['vi', $ns, $gr, 'index.col_value', 'Giá trị'],
            ['vi', $ns, $gr, 'index.col_actions', 'Thao tác'],

            ['vi', $ns, $gr, 'row.copy', 'Copy'],
            ['vi', $ns, $gr, 'row.copied', 'Đã copy!'],
            ['vi', $ns, $gr, 'row.edit', 'Sửa'],
            ['vi', $ns, $gr, 'row.delete', 'Xoá'],
            ['vi', $ns, $gr, 'row.confirm_delete', 'Xoá mục này?'],

            ['vi', $ns, $gr, 'form.title_edit', 'Sửa Bản dịch'],
            ['vi', $ns, $gr, 'form.title_create', 'Tạo Bản dịch'],
            ['vi', $ns, $gr, 'form.heading_edit', 'Sửa Bản dịch'],
            ['vi', $ns, $gr, 'form.heading_create', 'Tạo Bản dịch'],
            ['vi', $ns, $gr, 'form.subheading', 'Quản lý cặp khóa/bản dịch đa ngôn ngữ. Giữ naming nhất quán theo dot-notation.'],
            ['vi', $ns, $gr, 'form.error_generic', 'Vui lòng kiểm tra các trường bên dưới.'],
            ['vi', $ns, $gr, 'form.info', 'Thông tin'],
            ['vi', $ns, $gr, 'form.locale', 'Locale'],
            ['vi', $ns, $gr, 'form.locale_ph', 'vi'],
            ['vi', $ns, $gr, 'form.namespace', 'Namespace'],
            ['vi', $ns, $gr, 'form.namespace_ph', '*'],
            ['vi', $ns, $gr, 'form.namespace_help', 'Để <code>*</code> nếu không dùng.'],
            ['vi', $ns, $gr, 'form.group', 'Group'],
            ['vi', $ns, $gr, 'form.group_ph', 'homepage'],
            ['vi', $ns, $gr, 'form.key', 'Key'],
            ['vi', $ns, $gr, 'form.key_ph', 'welcome.title'],
            ['vi', $ns, $gr, 'form.key_help', 'Dot-notation. Ví dụ: <code>hero.title</code>, <code>buttons.save</code>.'],
            ['vi', $ns, $gr, 'form.value', 'Giá trị'],
            ['vi', $ns, $gr, 'form.value_ph', 'Plain text hoặc JSON (sẽ được lưu dạng chuỗi)'],
            ['vi', $ns, $gr, 'form.value_note', 'Có thể dán JSON; hệ thống sẽ lưu là chuỗi (string).'],
            ['vi', $ns, $gr, 'form.updated_by', 'Cập nhật bởi ID:'],
            ['vi', $ns, $gr, 'form.actions_section', 'Khu vực thao tác'],
            ['vi', $ns, $gr, 'form.save_changes', 'Lưu thay đổi'],
            ['vi', $ns, $gr, 'form.create', 'Tạo mới'],
            ['vi', $ns, $gr, 'form.save_and_new', 'Lưu & Tạo mới'],
            ['vi', $ns, $gr, 'form.cancel', 'Hủy'],
            ['vi', $ns, $gr, 'table.empty', 'Không có dữ liệu'],
            ['vi', $ns, $gr, 'table.prev', 'Trang trước'],
            ['vi', $ns, $gr, 'table.next', 'Trang sau'],
            ['vi', $ns, $gr, 'table.summary', 'Từ :from đến :to trên :total'],
            ['vi', $ns, $gr, 'table.goto_page', 'Tới trang :n'],

            // ===== EN =====
            ['en', $ns, $gr, 'index.title', 'Translations'],
            ['en', $ns, $gr, 'index.heading', 'Translation Management'],
            ['en', $ns, $gr, 'index.search_placeholder', 'Search...'],
            ['en', $ns, $gr, 'index.add_new', 'Add new'],
            ['en', $ns, $gr, 'index.col_locale', 'Locale'],
            ['en', $ns, $gr, 'index.col_namespace', 'Namespace'],
            ['en', $ns, $gr, 'index.col_group', 'Group'],
            ['en', $ns, $gr, 'index.col_key', 'Key'],
            ['en', $ns, $gr, 'index.col_value', 'Value'],
            ['en', $ns, $gr, 'index.col_actions', 'Actions'],

            ['en', $ns, $gr, 'row.copy', 'Copy'],
            ['en', $ns, $gr, 'row.copied', 'Copied!'],
            ['en', $ns, $gr, 'row.edit', 'Edit'],
            ['en', $ns, $gr, 'row.delete', 'Delete'],
            ['en', $ns, $gr, 'row.confirm_delete', 'Delete this item?'],

            ['en', $ns, $gr, 'form.title_edit', 'Edit Translation'],
            ['en', $ns, $gr, 'form.title_create', 'Create Translation'],
            ['en', $ns, $gr, 'form.heading_edit', 'Edit Translation'],
            ['en', $ns, $gr, 'form.heading_create', 'Create Translation'],
            ['en', $ns, $gr, 'form.subheading', 'Manage multilingual key/value pairs. Keep dot-notation consistent.'],
            ['en', $ns, $gr, 'form.error_generic', 'Please check the fields below.'],
            ['en', $ns, $gr, 'form.info', 'Info'],
            ['en', $ns, $gr, 'form.locale', 'Locale'],
            ['en', $ns, $gr, 'form.locale_ph', 'en'],
            ['en', $ns, $gr, 'form.namespace', 'Namespace'],
            ['en', $ns, $gr, 'form.namespace_ph', '*'],
            ['en', $ns, $gr, 'form.namespace_help', 'Use <code>*</code> if not used.'],
            ['en', $ns, $gr, 'form.group', 'Group'],
            ['en', $ns, $gr, 'form.group_ph', 'homepage'],
            ['en', $ns, $gr, 'form.key', 'Key'],
            ['en', $ns, $gr, 'form.key_ph', 'welcome.title'],
            ['en', $ns, $gr, 'form.key_help', 'Dot-notation, e.g. <code>hero.title</code>, <code>buttons.save</code>.'],
            ['en', $ns, $gr, 'form.value', 'Value'],
            ['en', $ns, $gr, 'form.value_ph', 'Plain text or JSON (stored as string)'],
            ['en', $ns, $gr, 'form.value_note', 'You can paste JSON; the system stores it as string.'],
            ['en', $ns, $gr, 'form.updated_by', 'Updated by ID:'],
            ['en', $ns, $gr, 'form.actions_section', 'Actions Section'],
            ['en', $ns, $gr, 'form.save_changes', 'Save changes'],
            ['en', $ns, $gr, 'form.create', 'Create'],
            ['en', $ns, $gr, 'form.save_and_new', 'Save & New'],
            ['en', $ns, $gr, 'form.cancel', 'Cancel'],
            ['en', $ns, $gr, 'table.empty', 'No data'],
            ['en', $ns, $gr, 'table.prev', 'Previous page'],
            ['en', $ns, $gr, 'table.next', 'Next page'],
            ['en', $ns, $gr, 'table.summary', 'Showing :from–:to of :total'],
            ['en', $ns, $gr, 'table.goto_page', 'Go to page :n'],
        ];

        // Chuẩn hóa cho upsert
        $values = array_map(function ($r) {
            [$locale, $namespace, $group, $key, $value] = $r;
            return [
                'locale'     => $locale,
                'namespace'  => $namespace,
                'group'      => $group, // reserved word, Eloquent tự backtick
                'key'        => $key,
                'value'      => $value,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $rows);

        Translation::query()->upsert(
            $values,
            ['locale', 'namespace', 'group', 'key'],
            ['value', 'updated_by', 'updated_at']
        );

        // (Nếu có cache i18n) xoá cache theo bộ này
        foreach (['vi', 'en'] as $lo) {
            Cache::forget("i18n:{$lo}:{$ns}:{$gr}");
        }
    }
}
