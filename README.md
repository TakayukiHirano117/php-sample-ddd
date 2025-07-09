# Blogアプリを作成する
- ユーザーはblogを作成できる
- ログインしていないとblogを作成・更新・削除できない。
- ユーザーは自分のblogしか更新・削除できない。
- ユーザーはログインしていなくてもblogを見ることができる。
- ユーザーは他のユーザーのblogも見ることができる。
- BookIdはUuidなので36桁


----  アプリケーションロジック ----

# handler
middlewareでログインチェック
func login?() -> bool
 
# usecase

# ここで組み立てて使う
 
# query_service
 
----  ドメインロジック ----
 
# domain

  # model

    # blog
    # user

      # バリデーションの中で
 
 
  # domain_service

    func can_i_delete_the_interview? -> bool

    func can_i_edit_the_interview? -> bool
 
# repository

  func insert_interview()

  func delete_interview()

  func update_interview()
 
 
----  技術ロジック ----

# infrastructure
 
 

要件をまとめてる時
 
 
#LEAFのblog登録機能

- blog登録

- blog削除

- blog編集

- blog一覧
 
# usecase

- blog登録

- ログインチェック → middleware or handler

- blog登録 → infrastructure
 
- blog削除

- ログインチェック → 上に同じ

- ログインユーザー(blog登録者)のblogかチェック → domain_service 

- blog削除 → infrastructure
 
- blog編集

- ログインチェック

- ログインユーザーの編集可能であるかチェック → domain_service

   - 編集権限がある or blogの作成者

- blog更新 → infrastructure
 
- blog一覧

# domain

  # model

    - blog

      - blog_id

      - interview_date

        - 3ヶ月先まで → model

    - proposal_product

      - id

      - name
 
# repository

    - interview_repository
 
  # domain service
 
 
 