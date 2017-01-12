<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
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

<div id="createtable"></div>
<div id="createrow"></div>
</body>
</html>