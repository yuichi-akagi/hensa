
drop TABLE hss;
drop TABLE univs ;
drop TABLE hs_stats;
drop TABLE hs_dept_stats;
drop TABLE pass_results ;
drop TABLE univ_stats;

--DROP TABLE university_stats;
-- DROP TABLE transition_results ;
-- DROP TABLE school_department_stats ;
--DROP TABLE school_stats ;
--DROP TABLE universities ;
-- DROP TABLE school_departments ;
--DROP TABLE schools;

-- 高校マスタテーブル
CREATE TABLE hss (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT UNIQUE NOT NULL,
    address TEXT,
    traffics TEXT,
    pattern TEXT,
    kinds TEXT CHECK(kinds IN ('私立','公立','国立')),
    gender TEXT CHECK(gender IN ('男子','女子','共学')),
    prefecture TEXT CHECK( prefecture IN ('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47')),
    lat NUMERIC,
    lng NUMERIC,
    is_integrated INTEGER DEFAULT 0,
    others TEXT,
    created_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    updated_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    deleted_at TEXT NULL
);

-- 大学マスタテーブル
CREATE TABLE univs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT UNIQUE NOT NULL,
    pattern TEXT,
    kinds TEXT CHECK(kinds IN ('私立', '国公立')),
    created_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    updated_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    deleted_at TEXT NULL
);

-------------------------------------------------------------------
-- テーブル1：高校統計テーブル
-- 　【項目】高校名・大学受験年・卒業生数・大学偏差値平均・入学年・入学整数・高校偏差値
-------------------------------------------------------------------
CREATE TABLE hs_stats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    hs_id INTEGER NOT NULL,  -- hssテーブルのidを参照
    grad_year INTEGER NOT NULL,         -- 大学受験年
    grad_count INTEGER,            -- 卒業生数
    grad_university_count INTEGER,            -- 卒業生うち大学生数
    grad_ss REAL,      -- 大学偏差値平均
    grad_ss_year INTEGER,         -- 偏差値計算対象年
    pass_ss REAL,
    pass_ss_year INTEGER,
    adm_year INTEGER,             -- 入学年
    adm_count INTEGER,            -- 入学整数（入学者数）
    adm_ss REAL,         -- 高校偏差値
    adm_ss_year INTEGER,         -- 偏差値計算対象年
    recruit_count INTEGER, --募集数
    comments TEXT,
    is_show INTEGER DEFAULT 0,
    dept_type TEXT CHECK (dept_type IN ('普通科','理数科','外国語科','その他','統合')),
    created_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    updated_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    deleted_at TEXT NULL,
    FOREIGN KEY (hs_id) REFERENCES hss(id)
);

-------------------------------------------------------------------
-- テーブル2：高校学科統計テーブル
-- 　【項目】高校名・学科名・学年・偏差値・生徒数
-------------------------------------------------------------------
CREATE TABLE hs_dept_stats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    hs_id INTEGER NOT NULL,    -- hssテーブルのidを参照
    dept_name TEXT,
    adm_year INTEGER,             -- 入学年
    adm_count INTEGER,            -- 入学整数（入学者数）
    adm_ss REAL,                     -- 偏差値
    adm_ss_year INTEGER,         -- 偏差値計算対象年
    comments TEXT,
    dept_type TEXT CHECK (dept_type IN ('普通科','理数科','外国語科','その他')),
    created_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    updated_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    deleted_at TEXT NULL,
    FOREIGN KEY (hs_id) REFERENCES hss(id)
);

-------------------------------------------------------------------
-- テーブル3：進学・合格実績テーブル
-- 　【項目】高校名・学科名・大学名・学部名・生徒数・年・実績（合格・進学）
-------------------------------------------------------------------
CREATE TABLE pass_results (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    hs_id INTEGER NOT NULL,    -- hssテーブルのidを参照
    dept_name TEXT,
    univ_id INTEGER NOT NULL,     -- universitiesテーブルのidを参照
    faculty_name TEXT NOT NULL,         -- 大学の学部名
    grad_year INTEGER NOT NULL,         -- 大学受験年
    grad_count INTEGER,            -- 卒業生数
    comments TEXT,
    result TEXT CHECK(result IN ('浪人合格','現役合格','合格', '進学')),  -- 実績（合格または進学）
    dept_type TEXT CHECK (dept_type IN ('普通科','理数科','外国語科','その他','統合')),
    created_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    updated_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    deleted_at TEXT NULL,
    FOREIGN KEY (hs_id) REFERENCES hss(id),
    FOREIGN KEY (univ_id) REFERENCES univs(id)
);

-------------------------------------------------------------------
-- テーブル4：大学統計テーブル
-- 　【項目】大学名・学部名・年・偏差値
-------------------------------------------------------------------
CREATE TABLE univ_stats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    univ_id INTEGER NOT NULL,     -- universitiesテーブルのidを参照
    faculty_name TEXT NOT NULL,         -- 学部名
    grad_year INTEGER NOT NULL,         -- 大学受験年
    grad_ss REAL,      -- 大学偏差値平均
    grad_ss_year INTEGER,         -- 偏差値計算対象年
    comments TEXT,
    created_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    updated_at TEXT NOT NULL DEFAULT (DATETIME('now', 'localtime')),
    deleted_at TEXT NULL,
    FOREIGN KEY (univ_id) REFERENCES univs(id)
);

