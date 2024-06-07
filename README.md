# 環境構築

1. Docker
2. Visual Studio Code
3. Git

上記は必ずインストールした上で始めてください。

## Macにおける環境構築

[MacOSにおける環境構築について](./docs/README-mac.md) を参照ください。

## Windows における環境構築

[Windowsにおける環境構築について](./docs/README-windows.md) を参照ください。

# テスト実行の仕方

必ず上記の環境構築にて、Laravel Railwayに取り組むための環境を整えてください。

Visual Studio Codeを使用してコードを編集し、「TechTrain Railway」という拡張機能から「できた!」と書かれた青いボタンをクリックすると判定が始まります。

詳細にテストを実施したい場合は、下記コマンドのStation番号を変更し、実行します。
```bash
# Station1のテストをする場合
docker compose exec php-container vendor/bin/phpunit tests/Feature/LaravelStations/Station1
```