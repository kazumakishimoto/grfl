# 1.アプリ概要
|key|value|
|---|-----|
|Name|飲食店とインフルエンサーのマッチングアプリ`grfl`|
|URL①|https://grfl.work/|
|URL②|https://grfl.herokuapp.com/|
|GitHub|https://github.com/kazumakishimoto/grfl|
|Qiita|https://qiita.com/kazumakishimoto/items/2ac669119c968e30ae37|

![top](https://user-images.githubusercontent.com/68370181/163541304-be60c925-76a3-4edd-abdc-f1f3d919d55a.png)

## コンセプト
- 飲食店が安価で簡単にSNS広告を始められるWEBアプリケーション
- 飲食店：広告依頼を投稿することで、インフルエンサーにSNS広告の募集ができる
- インフルエンサー：投稿一覧から自分に合った広告案件を発見できる

## 特徴
- 飲食店のSNS広告内容の投稿機能・画像アップロード機能
- 都道府県・カテゴリー別の投稿検索機能・ソート機能
- ダイレクトメッセージ機能(作成中)

## 使用画面のイメージ
![demo](https://user-images.githubusercontent.com/68370181/169194020-4e4f251c-2ec2-4934-bbe7-c815829d2dcf.png)


# 2.使用技術
## ディレクトリ構造
```
【ルートディレクトリ】
├─ .circleci
│   └─ config.yml
├─ aws / CloudFormation
│   └─ ec2.yml
├─ docker
│   └─ mysql
│   └─ nginx
│   └─ php
│   └─ phpmyadmin
├─ src
│   └─ 【Laravelのパッケージ】
└─ docker-compose.yml
```

## フロントエンド
- Vue.js 2.6.14
- jQuery 3.4.1
- HTML / CSS / Sass / Bootstrap

## バックエンド
- PHP	7.4.1
- Laravel	6.20.43
- PHPUnit	8.0

## DB
- MySQL	5.7.36
- PHPMyAdmin
- PostgreSQL(Heroku)

## 開発環境
- Git(Git-flow) / GitHub
- Docker	20.10.11 / docker-compose	v2.2.1
- VScode
- iTerm2
- MacOS

## 本番環境
- AWS(CloudFormation/VPC/EC2/RDS/S3/Route53/ALB/ACM/CodeDeploy/SNS/Chatbot/IAM/CloudWatch)
- Heroku 7.59.4
- CircleCI	2.1
- Nginx	1.18.0
- SendGrid

## パッケージ
- Composer 2.0.14
- npm 6.14.6
- Homebrew 3.4.2

## その他使用ツール
- draw.io
- Notion
- Google Sheets

# 3.機能一覧
## メイン機能
- ユーザー投稿機能(CRUD)
- 画像アップロード機能(AWS S3)
- ページネーション機能
- コメント機能(CRUD)
- タグ機能(Vue.js / Vue Tags Input)
- いいね機能(Vue.js / ajax)
- フォロー機能(Vue.js / ajax)
- キーワード検索機能(都道府県別ソート機能)
- お問い合わせ機能(SendGrid)
- PHPUnitテスト(CircleCI)
- レスポンシブデザイン(ハンバーガーメニュー)

## 認証機能
- 会員登録 / ログイン / ログアウト
- ゲストログイン機能
- Google会員登録 / ログイン(Google OAuth)
- Twitter会員登録 / ログイン(Twitter OAuth)
- プロフィール編集
- メールアドレス変更(SendGrid)
- パスワード再設定(SendGrid)
- 退会

## インフラ
- CloudFormationで環境構築(VPC / EC2)
- RDS for MySQL
- ACM × ELBでHTTPS化
- CircleCI × CodeDeployで自動デプロイ
- SNS × ChatbotでSlackデプロイ通知

##  実装予定
- EC2 / RDS冗長化
- 結合テスト / 統合テスト
- ユーザー検索機能
- DM機能
- 通知機能
- SNSシェア機能
- マルチログイン機能
- Linterで静的解析(Larastan)
- Formatterで自動整形(phpcs)
- パッケージを活用したデバッグ(Tinker / Xdebug)
- フロントエンド全般


# 4.基本設計
## 画面遷移図
![gui](https://user-images.githubusercontent.com/68370181/160355552-328990f2-bc02-4607-9a90-32a48eff4a85.png)

## 開発環境
- 開発環境は`Docker / docker-compose`
- ソース管理は`Git(Git-flow) / GitHub`
- IDEとOSは`VScode / MacOS`

|key|value|
|:--|:--|
|php|app|
|nginx|web|
|mysql|db|
|phpmyadmin|db管理|

## 本番環境
- 環境構築は`CloudFormation`
- CI/CDツールは`CircleCI / CodeDeploy`
- 独学にて`Subnet / Route53 / ALB / ACM / S3`を環境構築

![aws](https://user-images.githubusercontent.com/68370181/178103075-eec5508a-4d29-409c-84f4-3f687fa9cd5d.png)

|key|value|
|:--|:--|
|CloudFormation|環境構築|
|VPC|サブネット(EC2 / RDS)|
|EC2|nginx / php-fpm(public subnet 1a,1c)|
|RDS|MySQL(private subnet 1a,1c)|
|S3|画像用ストレージ|
|Route53|DNSレコード管理|
|ALB|ロードバランサー|
|ACM|SSL証明書取得(HTTPS化)|
|SNS|Slackデプロイ通知|
|Chatbot|Slackデプロイ通知|
|CircleCI|自動デプロイ|
|CodeDeploy|自動デプロイ|
|IAM|権限付与|
|CloudWatch|料金確認|

## ER図
- 独学にて`Commnts / Messages / Rooms / Entries`テーブル作成
![erd](https://user-images.githubusercontent.com/68370181/163666380-247d7cb3-3e61-4fdb-98fb-4f16d16aa59c.png)

## テーブル定義書
| テーブル名 | 説明 |
|----|----|
| Users | ユーザー情報 |
| Articles | 投稿情報 |
| Tags | 投稿のタグ情報 |
| Article_tags | ArticlesとTagsの中間テーブル |
| Likes | いいね情報 |
| Comments | コメント情報 |
| Follows | フォロー中/フォロワー情報 |
| Messages | ダイレクトメッセージ情報 |
| Rooms | ダイレクトメッセージのルーム情報 |
| Entries | MessagesとRoomsの中間テーブル |

https://docs.google.com/spreadsheets/d/1R7VARnAYGivhzmraesTzjtEwzi4NCR7UnvDdrqGi9NU/

# 5.作者
|key|value|
|---|-----|
|名前|岸本一眞(きしもとかずま)|
|住所|大阪市阿倍野区|
|趣味|サウナ / 筋トレ / アニメ / スパイスカレー / 愛犬とドライブ|
|ポートフォリオ|[**grfl.work**](https://grfl.work)|
|GitHub|[@kazumakishimoto](https://github.com/kazumakishimoto)|
|Qiita|[@kazumakishimoto](https://qiita.com/kazumakishimoto)|
|Twitter|[@kazuma_dev](https://twitter.com/kazuma_dev)|
|Wantedly|[@kazumakishimoto](https://www.wantedly.com/id/kazumakishimoto)|
|職務経歴書|https://github.com/kazumakishimoto/Curriculum-vitae|
