# Auth System (PHP) — Project Working Guide

## 1. Overview
This repository is a small PHP authentication system that supports:
- **User registration**
- **User login** (email + password)
- **Session-based authentication**
- **Protected dashboard** (requires login)
- **Logout** (clears session)

The app is structured using lightweight MVC-style layers:
- **Controllers** handle request logic.
- **Models** interact with the database.
- **Middleware** protects routes.
- **Views** render UI pages.
- **Routes/Route service** dispatch requests to controllers.

---

## 2. Entry Point and Bootstrapping
### `index.php`
`index.php` is the single entry point.
It does the following:
1. Defines `APP_ROOT`
2. Loads Composer autoloader (`vendor/autoload.php`)
3. Registers an extra `spl_autoload_register()` for class files
4. Starts the session via `session_start()`
5. Creates `App\Services\Route` and calls `handle()`
6. Includes route definitions from `routes/route.php`

**Request lifecycle:**
Browser request → `index.php` → `Route::handle()` → middleware → controller action → view output/redirect.

---

## 3. Routing System
### `auth/app/Services/Route.php`
This class maintains a static list of routes and dispatches them based on:
- `$_SERVER['REQUEST_URI']`
- `$_SERVER['REQUEST_METHOD']`

Key methods:
- `Route::get($uri, $controller, $action, $middleware = [])`
- `Route::post($uri, $controller, $action, $middleware = [])`
- `Route::handle()` loops over registered routes and on match:
  1. Runs each middleware’s `handle()` method
  2. Instantiates the controller
  3. Executes the action method

If no route matches, it prints: `404 - page not found`.

### `routes/route.php`
Defines these URL mappings:
- `GET /` → `HomeController@index`
- `GET /login` → `LoginController@index` with **Guest** middleware
- `GET /register` → `RegisterController@index` with **Guest** middleware
- `POST /submit-login` → `LoginController@login`
- `POST /submit-register` → `RegisterController@register`
- `GET /logout` → `DashboardController@logout` with **Auth** middleware
- `GET /dashboard` → `DashboardController@index` with **Auth** middleware

---

## 4. Middleware (Access Control)
Middleware runs before controller actions.

### `auth/app/Middleware/Auth.php`
Protects routes that require authentication.
- If `$_SESSION['user_id']` is not set:
  - `redirect("login")`
  - `exit()`

### `auth/app/Middleware/Guest.php`
Protects routes that should only be accessible when logged out.
- If `$_SESSION['user_id']` **is** set:
  - `redirect("dashboard")`
  - `exit()`

---

## 5. Controllers (Request Logic + View Rendering)
Controllers live in `auth/app/Controllers/`.

### `HomeController`
- `index()` prints `Home Page`.

### `LoginController`
- `index()` renders the login page via `view('auth.login')`.
- `login()` handles POST submission:
  1. Validates that `email` and `password` exist in `$_POST`.
  2. Creates `App\Models\User`, sets `$user->email` and `$user->password`.
  3. Calls `$user->login()`.
  4. On success:
     - sets `$_SESSION['user_id']` and `$_SESSION['user_name']`
     - redirects to `dashboard`
  5. On failure: prints `Login failed!`.

### `RegisterController`
- `index()` renders `view('auth.register')`.
- `register()` handles POST submission:
  1. Creates `User` model.
  2. Sets `$user->name`, `$user->email`, `$user->password` from `$_POST`.
  3. Calls `$user->register()`.
  4. On success prints `Registration successful!`.
  5. On failure prints `Registration failed!`.

> Note: UI includes `confirm_password`, but the backend currently ignores it.

### `DashboardController`
- `index()` renders `view('dashboard')`.
- `logout()`:
  - resets `$_SESSION = []`
  - calls `session_destroy()`
  - redirects to `login`

---

## 6. Models and Database
### `auth/app/Config/Database.php`
PDO connection configuration:
- host: `localhost`
- db name: `auth_system`
- user: `root`
- password: *(empty)*

Provides:
- `fetchData($query, $params = [])`
- `fetchSingle($query)`

### `auth/app/Models/BaseModel.php`
A minimal base class that extends `Database` so children can access `$this->conn`.

### `auth/app/Models/User.php`
Table: `users`

Public properties:
- `id`, `name`, `email`, `password`

#### `register()`
1. Checks if email already exists:
   - `SELECT * FROM users WHERE email = :email`
2. If exists: returns `false`.
3. Otherwise inserts a new user:
   - `INSERT INTO users (name, email, password) VALUES (:name, :email, :password)`
4. Password is hashed using:
   - `password_hash($this->password, PASSWORD_DEFAULT)`
5. Returns whether insert succeeded.

#### `login()`
1. Fetches user by email.
2. Verifies password with:
   - `password_verify($this->password, $user['password'])`
3. On success sets:
   - `$this->id`, `$this->name`
4. Returns `true`/`false`.

---

## 7. Views, Rendering Helpers, and Includes
### `auth/app/Helper.php`
Contains helpers:
- `view($file_path)`
  - loads: `pages/<file_path>.php`
- `redirect($url)`
  - uses `header("Location: $url")` then `exit()`
- `pageAdd($file_path)`
  - includes header/footer partials from `pages/`

### Pages folder
- `pages/auth/login.php` → login form
- `pages/auth/register.php` → register form
- `pages/dashboard.php` → dashboard with welcome name
- `pages/includes/header.php`, `pages/includes/footer.php` → Bootstrap layout

---

## 8. End-to-End Flows

### A) Register
1. `GET /register` (Guest middleware ensures user is logged out)
2. Register form submits `POST /submit-register`
3. `RegisterController@register()` calls `User->register()`
4. Inserts into DB and prints success/failure.

### B) Login
1. `GET /login` (Guest middleware)
2. Login form submits `POST /submit-login`
3. `LoginController@login()` calls `User->login()`
4. Sets session values and redirects to `/dashboard`.

### C) Dashboard Protection
- `GET /dashboard` (Auth middleware)
- If session has no `user_id` → redirect to `/login`.

### D) Logout
- `GET /logout` (Auth middleware)
- Clears session and redirects to `/login`.

---

## 9. Notes / Limitations (Current Behavior)
- `confirm_password` is collected in the UI but not validated server-side.
- Errors are output as simple `echo` strings (no structured error UI).
- Route matching is strict on `REQUEST_URI` and `REQUEST_METHOD` and supports only the defined static routes.

---

## 10. Quick File Map
- `index.php`
- `routes/route.php`
- `auth/app/Services/Route.php`
- `auth/app/Middleware/Auth.php`
- `auth/app/Middleware/Guest.php`
- `auth/app/Controllers/*`
- `auth/app/Models/*`
- `auth/app/Config/Database.php`
- `auth/app/Helper.php`
- `pages/*`

