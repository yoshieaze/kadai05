# kadai05
# サポート問い合わせページの作成

## 1. 操作方法、実装内容

### 課題説明
- 3回目の課題で作成したチャットアプリに、サポート機能を実装する形にしました
- また、サポートの問い合わせが一覧で確認できるページを用意しました。
- 本来はログインユーザーの権限に対応して管理者ページが表示、非表示できるべきですが、SQLになってから実装しようと思っています

### 操作方法
### ユーザー問い合わせの操作
- index.htmlがメインの内容となっており、ページのヘッダにSupportというページより問い合わせページに飛べます
- index.htmlはログイン機能を備えており、top.htmlよりログインできますが、<br>
  今回はログインの有無は影響しないので、ユーザーは作成いただかなくて大丈夫です
- Supportページに遷移すると、名前、メールアドレス、お問い合わせ内容が記載できるエリアがあります
- 記入いただき、画面下のボタンを押すと、確認画面に遷移します
- 戻るボタンを用意しているので、問い合わせ内容を修正する場合は戻ることができます。戻っても記入内容を保持されています
- 確認して問題なければ、Submitボタンを押します
- 完了画面からチャットの画面に戻ることができるようリンクを置いてあります
- 完了画面に行く際に、data/data.txtに問い合わせ内容を書き込む処理を入れています

### 管理者画面
- Supportページの右上に、管理者画面、という文字があります。クリックすると問い合わせ一覧が確認できます
- data/data.txtの内容を確認できます
- 現状、内容欄で改行をすると、正しく表が作成されません。

## 2.実装の工夫
- BootStrap https://getbootstrap.com/ で装飾しています
- Udemyの講座を参考に、セキュリティ対策(HTMLSpecial Character）をできる範囲で実装しました

## 3.疑問点
- textareaが改行すると、テキストファイルで保持した内容も改行コードはテキストファイルに保持されるものの、実際に改行されてしまいます。１行で保持したかったのですが、どうすればいいかわかりませんでした。
- 元々JSON形式で保存していたものを頑張ろうとしていたのですが、挫折してしまい、急遽カンマ区切りで実装しました
