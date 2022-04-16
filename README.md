# 1.アプリ概要

- 飲食店とインフルエンサーのマッチングアプリ

- URL(AWS):
- URL(Heroku):https://grfl.herokuapp.com/
- GitHub:https://github.com/kazumakishimoto/grfl

![top](https://user-images.githubusercontent.com/68370181/163541304-be60c925-76a3-4edd-abdc-f1f3d919d55a.png)

## コンセプト
- 集客に困っている飲食店が簡単にSNS広告を始められる
- 広告案件を探しているインフルエンサーがすぐに飲食店を見つけられる
- 『安価で簡単』に広告を始められるアプリです

## 特徴
- エリアやジャンル別で飲食店・インフルエンサーを発見できる
- 具体的な広告内容や広告条件を投稿内容から確認できる
- ダイレクトメッセージで連絡できる

## 使用画面のイメージ

(画像)


# 2.使用技術

## フロントエンド
- Vue.js 2.6.14
- jQuery 3.4.1
- HTML / CSS / Sass / MDBootstrap

## バックエンド
- PHP	7.4.1
- Laravel	6.20.43
- PHPUnit	8.0

## インフラ
- AWS(EB,VPC,EC2,RDS,Route53,ALB,ACM,SNS,Chatbot,IAM,CloudWatch,CloudFormation,CodeDeploy)
- Heroku 7.59.4
- Docker	20.10.11 / docker-compose	v2.2.1
- CircleCI	2.1
- nginx	1.18.0
- MySQL	5.7.36
- SendGrid

## パッケージ
- Composer 2.0.14
- npm 6.14.6
- Homebrew 3.4.2

## その他使用ツール
- Git / GitHub
- PHPMyAdmin
- VScode
- draw.io
- MacBook Air	M1,2020(macOS	Monterey 12.3)


# 3.機能一覧

## メイン機能
- ユーザー投稿機能(CRUD)
- 画像アップロード機能(AWS S3バケット)
- ページネーション機能
- コメント機能(CRUD)
- タグ機能(Vue.js / Vue Tags Input)
- いいね機能(Vue.js / ajax)
- フォロー機能(Vue.js / ajax)
- キーワード検索機能(都道府県別ソート機能)
- お問い合わせ機能(SendGrid)
- PHPUnitテスト(CircleCI)
- レスポンシブWEBデザイン(ハンバーガーメニュー)

## 認証機能
- 会員登録 / ログイン / ログアウト
- ゲストログイン機能
- Google アカウントを利用した会員登録・ログイン(GCP OAuth)
- プロフィール編集
- メールアドレス変更(SendGrid)
- パスワード再設定(SendGrid)
- 退会

## 実装予定(2022/04/15時点)
- Twitter アカウントを利用した会員登録・ログイン(Twitter OAuth)
- ユーザー検索機能
- DM機能
- SNSシェア機能
- AWSデプロイ


# 4.基本設計

## 画面遷移図
![gui](https://user-images.githubusercontent.com/68370181/160355552-328990f2-bc02-4607-9a90-32a48eff4a85.png)

## AWS構成図
![aws](https://user-images.githubusercontent.com/68370181/160355537-82139efe-be99-4bb2-8661-5af5e981a899.png)

## ER図
![erd](https://user-images.githubusercontent.com/68370181/163666380-247d7cb3-3e61-4fdb-98fb-4f16d16aa59c.png)

## テーブル定義書

https://docs.google.com/spreadsheets/d/1R7VARnAYGivhzmraesTzjtEwzi4NCR7UnvDdrqGi9NU/edit?usp=sharing

| テーブル名 | 説明 |
|----|----|
| Users | ユーザー情報 |
| Articles | ユーザー投稿情報 |
| Tags | ユーザー投稿のタグ情報 |
| Article_tags | ArticlesとTagsの中間テーブル |
| Likes | ユーザー投稿のいいね情報 |
| Comments | ユーザー投稿のコメント情報 |
| Follows | フォロー中/フォロワーのユーザー情報 |
| Messages | ユーザー間のダイレクトメッセージ情報 |
| Rooms | ダイレクトメッセージのルーム情報 |
| Entries | MessagesとRoomsの中間テーブル |


# 5.作者
|key|value|
|---|-----|
|Name|岸本一眞(きしもとかずま)|
|Wantedly|[岸本一眞](https://www.wantedly.com/id/kazumakishimoto)|
|Twitter|[@kazuma_dev](https://twitter.com/kazuma_dev)|
|Qiita|[@kazumakishimoto](https://qiita.com/kazumakishimoto)|
|GitHub|[@kazumakishimoto](https://github.com/kazumakishimoto)|
|個人開発|[**grfl**](https://grfl.herokuapp.com/)|
