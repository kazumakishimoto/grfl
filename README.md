# 1.アプリ概要
|key|value|
|---|-----|
|Name|飲食店とインフルエンサーのマッチングアプリ`grfl`|
|URL(AWS)|https://grfl.work/|
|URL(Heroku)|https://grfl.herokuapp.com/|
|解説記事|https://qiita.com/kazumakishimoto/items/2ac669119c968e30ae37|
|GitHub|https://github.com/kazumakishimoto/grfl|

![top](https://user-images.githubusercontent.com/68370181/163541304-be60c925-76a3-4edd-abdc-f1f3d919d55a.png)

## コンセプト
- 【飲食店】手軽にSNS集客を始められる
- 【インフルエンサー】広告募集中の飲食店を見つけられる
- 『安価&簡単』にSNS集客できるWEBアプリケーション

## 特徴
- 広告内容や広告条件の発信
- 都道府県やカテゴリー別の飲食店・インフルエンサー検索
- ダイレクトメッセージで連絡(※作成中)

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
- MacBook Air	M1,2020(macOS	Monterey 12.3)

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

|key|value|
|:--|:--|
|php|app|
|nginx|web|
|mysql|db|
|phpmyadmin|db管理|

## 本番環境
- AWS構成図
- 本番環境は開発環境と同じ`LEMP環境`
- CI/CDツールは`CircleCI`

![aws](https://user-images.githubusercontent.com/68370181/166865919-21a4babf-2e8f-4bdf-aefa-e540026c9280.png)

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

https://docs.google.com/spreadsheets/d/1R7VARnAYGivhzmraesTzjtEwzi4NCR7UnvDdrqGi9NU/edit?usp=sharing

# 5.作者
|key|value|
|---|-----|
|名前|岸本一眞(きしもとかずま)|
|生年月日|1993/01/14|
|居住地|大阪市阿倍野区(天王寺駅)|
|趣味|筋トレ/サウナ/ガジェット/スパイスカレー|
|Wantedly|[岸本一眞](https://www.wantedly.com/id/kazumakishimoto)|
|Twitter|[@kazuma_dev](https://twitter.com/kazuma_dev)|
|Qiita|[@kazumakishimoto](https://qiita.com/kazumakishimoto)|
|GitHub|[@kazumakishimoto](https://github.com/kazumakishimoto)|
|職務経歴書|https://github.com/kazumakishimoto/Curriculum-vitae|
