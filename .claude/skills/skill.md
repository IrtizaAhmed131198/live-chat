# Live Chat Project – Skill Document

## Overview
A Laravel 12 live chat platform that supports real-time messaging, visitor tracking, heatmaps, and form submissions. The app integrates with **Pusher** (via Laravel Reverb) and uses **Yajra DataTables** for admin listing views.

---

## Key Architecture Points

| Layer | Description |
|-------|-------------|
| **Routes** | `routes/web.php` – All authenticated web routes (admin & profile).<br>`routes/api.php` – Widget & API endpoints for external calls. |
| **Controllers** | Split into two groups: `App\Http\Controllers` (admin + visitor facing) and `App\Http\Controllers\Api` (public/widget endpoints). |
| **Models** | `App\Models` contains: `User`, `Visitor`, `Chat`, `Message`, `Brand`, `FormSubmission`, `HeatmapEvent`, etc. |
| **Views** | Blade templates live in `resources/views/admin` (admin layout) and `resources/views/widget` (chat widget snippets). |
| **Middleware** | Uses `role:1`, `role:1,2`, `auth`, `lastseen`. Custom middleware `lastseen` tracks last activity. |
| **Helpers** | `app/Helpers/helpers.php` contains global functions like `emit_pusher_notification()`. |

---

## Admin Flow (Typical Listing Page)
1. **Route** – e.g., `admin.users` → `UserController@index` → returns `admin.user.index`.
2. **Index View** – extends `admin.layout.app`; renders a card with DataTables.
3. **Data Route** – e.g., `admin.users.data` → `UserController@getUsers` → returns JSON via Yajra.
4. **JS** – Initializes DataTables with `serverSide: true`, custom filters, and AJAX reload.

---

## New Feature: Form Submissions
| Item | File | Purpose |
|------|------|---------|
| **Model** | `app/Models/FormSubmission.php` | Fields: `brand_id`, `page_url`, `form_action`, `form_method`, `form_data`, `meta`. |
| **API Endpoint** | `routes/api.php` `POST /form-submissions` | Public endpoint for widget to submit form data. |
| **Admin Controller** | `app/Http/Controllers/Admin/FormSubmissionsController.php` | `index()`, `getFormSubmissions()`, `show($id)`. |
| **Admin Routes** | `routes/web.php` | `admin.form-submissions`, `admin.form-submissions.data`, `admin.form-submissions.show`. |
| **Views** | `resources/views/admin/form-submissions/{index.blade.php, show.blade.php, partials/actions.blade.php}` | List, detail, and action button partial. |
| **Sidebar** | `resources/views/admin/layout/sidebar.blade.php` | Added “Form Submissions” link. |

---

## Commands & Scripts
| Command | Description |
|---------|-------------|
| `composer setup` | Install deps, copy `.env`, migrate, build assets. |
| `composer dev` | Serve, queue, logs, vite concurrently. |
| `composer test` | Run PHPUnit tests. |
| `php artisan migrate` | Run migrations. |
| `php artisan reverb:start` | Start Reverb server (if used instead of Pusher). |

---

## Quick Reference for New Features
* **Add admin list page**: Add route in `routes/web.php`, add controller method, create Blade view under `resources/views/admin/{feature}/index.blade.php`, update sidebar.
* **Add DataTables page**: Add `GET {route}/data` → Yajra response; add JS block as in `user/index.blade.php`.
* **Add public API**: Add route + controller in `routes/api.php`; keep validation consistent with existing API patterns.

---

## Dependencies
* Laravel Framework 12.x
* Pusher + Laravel Reverb (realtime)
* Laravel Sanctum (API tokens)
* Yajra DataTables (Oracle)
* Jenssegers/Agent (browser detection)
* FakerPHP/Faker (seeding)