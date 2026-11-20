/* =========================================================
   AuraDev / モフモフLife
   Presentation Demo Initial Data
   ※ テーブル定義（CREATE TABLE）は含みません。
   ※ 既存の users / pets / tasks テーブルに対して実行してください。
   ========================================================= */


/* =========================================================
   PETS
   Each user has exactly 3 pets:
   Level 5 / Level 9 / Level 19
   Different HP and adoption dates demonstrate the system.
   ========================================================= */


/* -------------------------
   Chaw
   ------------------------- */

INSERT INTO pets
(user_id, type, hp, level, is_selected, adopt_date, last_hp_update)
VALUES
(1, "hamster", 86, 5, TRUE, "2026-07-15", "2026-09-03 09:00:00"),
(1, "cat",      58, 9, FALSE, "2026-07-28", "2026-09-03 09:00:00"),
(1, "dog",       34, 19, FALSE, "2026-06-10", "2026-09-03 09:00:00");


/* -------------------------
   Yamin
   ------------------------- */

INSERT INTO pets
(user_id, type, hp, level, is_selected, adopt_date, last_hp_update)
VALUES
(2, "rabbit", 92, 5, TRUE, "2026-07-05", "2026-09-03 09:00:00"),
(2, "cat",    71, 9, FALSE, "2026-06-25", "2026-09-03 09:00:00"),
(2, "dog",    45, 19, FALSE, "2026-05-18", "2026-09-03 09:00:00");


/* -------------------------
   Sint
   ------------------------- */

INSERT INTO pets
(user_id, type, hp, level, is_selected, adopt_date, last_hp_update)
VALUES
(3, "hamster", 64, 5, TRUE, "2026-07-20", "2026-09-03 09:00:00"),
(3, "dog",      39, 9, FALSE, "2026-06-30", "2026-09-03 09:00:00"),
(3, "cat",      18, 19, FALSE, "2026-05-05", "2026-09-03 09:00:00");


/* -------------------------
   Enn
   ------------------------- */

INSERT INTO pets
(user_id, type, hp, level, is_selected, adopt_date, last_hp_update)
VALUES
(4, "cat",    97, 5, TRUE, "2026-08-01", "2026-09-03 09:00:00"),
(4, "rabbit", 76, 9, FALSE, "2026-07-10", "2026-09-03 09:00:00"),
(4, "hamster",52, 19, FALSE, "2026-06-01", "2026-09-03 09:00:00");


/* -------------------------
   Hnin
   ------------------------- */

INSERT INTO pets
(user_id, type, hp, level, is_selected, adopt_date, last_hp_update)
VALUES
(5, "hamster", 100, 5, TRUE, "2026-08-05", "2026-09-03 09:00:00"),
(5, "cat",       83, 9, FALSE, "2026-07-01", "2026-09-03 09:00:00"),
(5, "dog",       27, 19, FALSE, "2026-05-20", "2026-09-03 09:00:00");


/* =========================================================
   TASKS
   Each user has completed and pending tasks,
   including both TODO and SCHEDULE examples.
   ========================================================= */


/* -------------------------
   Chaw
   ------------------------- */

INSERT INTO tasks
(user_id, title, type, description, status, start_time, end_time, rewarded)
VALUES
(1, "バックエンド開発", "todo",
 "APIとデータベースの処理を実装する",
 "completed", "2026-08-31 09:00:00", "2026-08-31 12:00:00", TRUE),

(1, "テスト確認", "todo",
 "主要機能の動作を確認する",
 "completed", "2026-09-01 13:00:00", "2026-09-01 14:30:00", TRUE),

(1, "チームミーティング", "schedule",
 "プロジェクトの進捗を確認する",
 "pending", "2026-09-04 15:00:00", "2026-09-04 16:00:00", FALSE),

(1, "発表練習", "schedule",
 "プレゼンテーションの練習を行う",
 "pending", "2026-09-07 14:00:00", "2026-09-07 15:00:00", FALSE);


/* -------------------------
   Yamin
   ------------------------- */

INSERT INTO tasks
(user_id, title, type, description, status, start_time, end_time, rewarded)
VALUES
(2, "UIデザイン修正", "todo",
 "画面デザインを確認して修正する",
 "completed", "2026-08-30 10:00:00", "2026-08-30 12:00:00", TRUE),

(2, "画像素材整理", "todo",
 "プロジェクトで使用する画像を整理する",
 "completed", "2026-09-01 13:00:00", "2026-09-01 14:00:00", TRUE),

(2, "プレゼン資料作成", "todo",
 "発表用のスライドを作成する",
 "pending", "2026-09-04 10:00:00", "2026-09-04 12:00:00", FALSE),

(2, "チーム発表練習", "schedule",
 "チームで発表内容を確認する",
 "pending", "2026-09-06 15:00:00", "2026-09-06 16:30:00", FALSE);


/* -------------------------
   Sint
   ------------------------- */

INSERT INTO tasks
(user_id, title, type, description, status, start_time, end_time, rewarded)
VALUES
(3, "機能テスト", "todo",
 "ログインとタスク機能をテストする",
 "completed", "2026-08-29 10:00:00", "2026-08-29 11:30:00", TRUE),

(3, "バグ修正", "todo",
 "発見した不具合を修正する",
 "completed", "2026-09-01 14:00:00", "2026-09-01 16:00:00", TRUE),

(3, "最終動作確認", "todo",
 "システム全体の最終確認を行う",
 "pending", "2026-09-04 13:00:00", "2026-09-04 15:00:00", FALSE),

(3, "成果発表", "schedule",
 "プロジェクトの成果を発表する",
 "pending", "2026-09-08 10:00:00", "2026-09-08 11:00:00", FALSE);


/* -------------------------
   Enn
   ------------------------- */

INSERT INTO tasks
(user_id, title, type, description, status, start_time, end_time, rewarded)
VALUES
(4, "フロントエンド修正", "todo",
 "画面表示とレイアウトを調整する",
 "completed", "2026-08-31 09:00:00", "2026-08-31 11:00:00", TRUE),

(4, "レスポンシブ確認", "todo",
 "スマートフォン表示を確認する",
 "completed", "2026-09-02 10:00:00", "2026-09-02 11:00:00", TRUE),

(4, "最終チェック", "todo",
 "システム全体の最終確認を行う",
 "pending", "2026-09-05 10:00:00", "2026-09-05 12:00:00", FALSE),

(4, "チーム発表", "schedule",
 "モフモフLifeの成果を発表する",
 "pending", "2026-09-08 13:00:00", "2026-09-08 14:00:00", FALSE);


/* -------------------------
   Hnin
   ------------------------- */

INSERT INTO tasks
(user_id, title, type, description, status, start_time, end_time, rewarded)
VALUES
(5, "DB設計", "todo",
 "テーブルとリレーションを設計する",
 "completed", "2026-08-29 10:00:00", "2026-08-29 12:00:00", TRUE),

(5, "ER図作成", "todo",
 "データベース構造をER図にまとめる",
 "completed", "2026-09-01 14:00:00", "2026-09-01 15:30:00", TRUE),

(5, "発表資料確認", "todo",
 "データベース関連の発表資料を確認する",
 "pending", "2026-09-04 18:00:00", "2026-09-04 19:00:00", FALSE),

(5, "チームミーティング", "schedule",
 "発表内容と役割を最終確認する",
 "pending", "2026-09-06 15:00:00", "2026-09-06 16:00:00", FALSE);



/* ****************
    tasks init data
*******************
*/
INSERT INTO tasks (user_id, title, type, description, status, start_time, end_time) VALUES 
(1,
"BackEnd",
"todo",
"プロジェクトのベックエンド",
"pending",
'2026-5-22',
'2026-6-25'
);

INSERT INTO tasks (user_id, title, type, description, status, start_time, end_time) VALUES 
(2,
"FrontEnd",
"todo",
"プロジェクトのフロントエンド",
"pending",
'2026-5-22',
'2026-6-25'
);


COMMIT;
