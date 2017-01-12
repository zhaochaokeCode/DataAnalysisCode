<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">

    <link rel="stylesheet" type="text/css" href="/css/paginator/bootstrap.css" >

    <!--日期时间样式-->
    <link type="text/css" rel="stylesheet" href="/js/jedate/skin/jedate.css">
    <title>动态创建表格</title>
    <script src="/js/jquery/jquery-2.0.3.min.js"></script>
    <script type="text/javascript">
        $(function () {
            CreateTable(5, 6)
        });
        function CreateTable(rowCount, cellCount) {
            var table = $("<table border=\"1\">");
            $.ajax({
                url: "/index/test",
                datatype: 'json',
                type: "Post",
                data: "id=",
                success: function (data) {
                    if (data != null) {
                        $.each(eval(data), function (index, item) { //遍历返回的json.
                            var table = $("<table border=\"1\">");
                            table.appendTo($("#createtable"));
                            for (var i = 0; i < rowCount; i++) {
                                var tr = $("<tr></tr>");
                                tr.appendTo(table);
                                for (var j = 0; j < cellCount; j++) {
                                    var td = $("<td>" + i * j + "</td>");
                                    td.appendTo(tr);
                                }
                            }
                            $("</table>").appendTo($("#createtable"));
                        })
                    }
                }
            })

        }
    </script>
</head>

<body>
<input type="button" value="添加表格" onClick="CreateTable(5,6)">
<input type="button" value="添加行">

<div id="example"></div>
<div id="createrow"></div>
<script src="/js/jquery/jquery-2.0.3.min.js"></script>
<script src="/js/bootstrap-paginator.min.js"></script>
<script src="/js/hightcharts/comm_get_highdatas.js"></script>
<script type="text/javascript">
    $(function () {
        var all_data = 123;
        initDatas(all_data);

    })
</script>
</body>
</html>