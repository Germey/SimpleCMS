@echo off
title jszip.com jszip bat By kth007
echo ******************************************************************************
echo *
echo *    js合并压缩生成工具 bat版本 By kth007
echo *
echo ******************************************************************************
echo 请按回车键开始压缩。
pause>nul
cls

@SET PHP="D:\wamp\bin\php\php5.3.5\php.exe"

echo 开始生成，请稍后...
echo .


echo 2>index_no.js
type jquery.js >> index_no.js
type jquery.placeholder.min.js >> index_no.js
type jquery.validator.js >> index_no.js
type map.js  >> index_no.js
type application.js >> index_no.js
type customize.js >> index_no.js

%PHP% php/example-file.php index_no.js index_no.js

copy index_no.js ..\js\main.js

echo js/main.js 已经生成！TIME: %time%
echo. & pause