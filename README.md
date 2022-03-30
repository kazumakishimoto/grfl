# grfl

- 飲食店とインフルエンサーのマッチングアプリ

URL:https://grfl.herokuapp.com/

(画像)

# 1.アプリ概要

## コンセプト
- 集客に困っている飲食店が簡単にSNS広告を始められる
- 広告案件を探しているインフルエンサーがすぐに飲食店を見つけられる
- 『安価で簡単』に広告を始められるアプリです

## 特徴
- エリアやジャンル別で飲食店・インフルエンサーを発見できる
- 具体的な広告内容や広告条件を投稿内容から確認できる
- ダイレクトメッセージで連絡できる

## 解説記事(Qiita)
URL:

# 2.使用画面のイメージ

(画像)

# 3.使用技術
## フロントエンド
- Vue.js 2.6.14
- jQuery 3.4.1
- HTML / CSS / Sass / MDBootstrap

## バックエンド
- PHP	7.4.1
- Laravel	6.20.43
- Composer	2.0.14
- PHPUnit	8.0

## インフラ
- AWS(EB,VPC,EC2,RDS,Route53,ALB,ACM,SNS,Chatbot,IAM,CloudWatch,CloudFormation,CodeDeploy)
- Heroku 7.59.4
- Docker	20.10.11 / docker-compose	v2.2.1
- CircleCI	2.1
- nginx	1.18.0
- MySQL	5.7.36

## その他使用ツール
- Git	2.33.1 / GitHub
- PHPMyAdmin
- VScode
- draw.io
- MacBook Air	M1,2020(macOS	Monterey 12.3)

# 4.画面遷移図
![gui](https://user-images.githubusercontent.com/68370181/160355552-328990f2-bc02-4607-9a90-32a48eff4a85.png)

# 5.AWS構成図
![aws](https://user-images.githubusercontent.com/68370181/160355537-82139efe-be99-4bb2-8661-5af5e981a899.png)

# 6.ER図
![erd](https://user-images.githubusercontent.com/68370181/160355549-1aa3f92a-0f02-4f0b-87fe-a29fae9544f8.png)

# 7.各テーブルについて
| テーブル名 | 説明 |
----|----
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

# 8.機能一覧

## メイン機能
- ユーザー投稿機能(CRUD)
- ページネーション機能
- コメント機能(CRUD)
- タグ機能(Vue.js / Vue Tags Input)
- いいね機能(Vue.js / ajax)
- フォロー機能(Vue.js / ajax)
- 投稿検索機能
- お問い合わせ機能(SendGrid)
- PHPUnitテスト(CircleCI)
- レスポンシブWEBデザイン(ハンバーガーメニュー)

## 認証機能
- ユーザー登録 / ログイン / ログアウト
- ゲストログイン機能
- Google アカウントを利用したユーザー登録・ログイン(GCP OAuth)
- プロフィール編集 / アカウント削除
- メールアドレス変更(SendGrid)
- パスワード再設定(SendGrid)

## 実装予定(2022/03/31時点)
- Twitter アカウントを利用したユーザー登録・ログイン(Twitter OAuth)
- 画像アップロード機能(AWS S3バケット)
- ユーザー検索機能
- ソート検索機能(昇順 / 降順 / いいね順 / コメント数順)
- DM機能
- SNSシェア機能
- AWSデプロイ

# 9.作者
- kazumakishimoto
- Twitter:https://twitter.com/kazuma_dev
- GitHub:https://github.com/kazumakishimoto
- Qiita:https://qiita.com/kazumakishimoto
