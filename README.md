## 概要 todo_app_api_laravel

Laravel API を用いて作成した Todo アプリ

## 機能

-   タスクの一覧取得(GET)
-   タスクの作成(POST)
-   タスクの更新(PUT/PATCH)
-   タスクの削除(DELETE)
-   シンプルな RESTful API
-   データベース(PostgreSQL)/マイグレーション済み

## 環境構築

### 前提条件

-   PHP 8.4.12
-   Composer 2.8.12
-   Laravel 12.34.0
-   データベース(PostgreSQL) 14.19

## 開発環境構築

### データベース(PostgreSQL)

```bash
brew services start postgresql
```

PostgreSQL で Database とユーザを作成

```bash
psql postgres
psql (14.19 (Homebrew))
Type "help" for help.

postgres=#
```

```bash
CREATE DATABASE todo_app;
CREATE USER todo_user WITH ENCRYPTED PASSWORD 'your_password';
GRANT ALL PRIVILEGES ON DATABASE todo_app TO todo_user;
\q
```

### 環境設定ファイル(.env)

```bash
git clone https://github.com/hitsuji-man/todo_app_api_laravel.git
cd todo_app_api_laravel
```

.env ファイル
(通常は.env ファイルには機密事項が含まれるため、README には記載しないほうがいい。事実.gitignore に含めている。)

```bash
APP_NAME=TodoApp
APP_ENV=local
APP_KEY=base64:ランダムな文字列
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=todo_app
# DB_USERNAME=todo_user
# DB_PASSWORD=
```

### データベースの設定の確認

config/database.php ファイルを開き、PostgreSQL の設定を確認します。

```php
// デフォルト
'default' => env('DB_CONNECTION', 'pgsql'),

// PostgreSQL設定部分
'pgsql' => [
        'driver' => 'pgsql',
        'url' => env('DATABASE_URL'),
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '5432'),
        'database' => env('DB_DATABASE', 'todo_app'),
        'username' => env('DB_USERNAME', 'todo_user'),
        'password' => env('DB_PASSWORD', 'your_password'),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
],
```

### マイグレーションの実行と開発サーバの起動

```bash
php artisan migrate
php artisan serve
```
