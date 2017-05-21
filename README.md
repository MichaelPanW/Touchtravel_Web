# Dcard_php_reptile Dcard爬蟲實作
這是實作利用爬蟲 抓取Dcard文章的專案

用的是thinkphp框架

已停止實際運作，可供大家練習用

使用前請更改db.config.php資料資料
並匯入dcard_database.sql資料表
大部分資料進資料庫都會做utf8轉碼

主要是ajaxcontrol.php中運作
打開"爬蟲區"就開始抓資料了

分別以
#Ajax/article
抓各分類熱門及最新文章
標題 url 按讚數節取出來
並轉碼存進資料庫

#Ajax/content
負責將抓到的url
抓取個文章內容
並轉碼存進資料庫

#Ajax/hiddcheck
負責固定查找已有資料
是否已消失在這個世界

練習爬蟲用 公開可能會被吉歐~啾咪^^
