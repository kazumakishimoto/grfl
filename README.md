# grfl

- 飲食店とインフルエンサーのマッチングアプリ

URL:https://grfl.herokuapp.com/

(画像)

# 1.アプリ概要

## コンセプト
- 集客に困っている飲食店が、簡単にSNS広告ができる
- 広告案件を探しているインフルエンサーが、すぐに飲食店を見つけられる

## 特徴

## 解説記事(Qiita)
URL:

# 2.使用画面のイメージ

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

# 5.AWS構成図

# 6.ER図

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

## 認証機能

# 9.作者
- kazumakishimoto
- Twitter:https://twitter.com/kazuma_dev
- GitHub:https://github.com/kazumakishimoto
- Qiita:https://qiita.com/kazumakishimoto
