<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">

</head>
<body>
<div id="createtable"></div>
<div id="createrow"></div>

</body>
</html>

<script src="/js/jquery/jquery-2.0.3.min.js"></script>

<!-- 新 Bootstrap 核心 CSS 文件 -->
<!--<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>-->
<!--<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">-->
<!--<script src="/js/bootstrap-paginator.min.js"></script>-->
<script type="text/javascript">
    $(function(){
        var table=$("<table border=\"1\">");
        table.appendTo($("#createtable"));
        for(var i=0;i<rowCount;i++)
        {
            var tr=$("<tr></tr>");
            tr.appendTo(table);
            for(var j=0;j<cellCount;j++)
            {
                var td=$("<td>"+i*j+"</td>");
                td.appendTo(tr);
            }
        }
        trend.appendTo(table);
        $("#createtable").append("</table>");

    })




//        var carId = 1;
//        $.ajax({
//            url: "/index/test",
//            datatype: 'json',
//            type: "Post",
//            data: "id=" + carId,
//            success: function (data) {
//                if (data != null) {
//                    $.each(eval(data), function (index, item) { //遍历返回的json
//
//                        $("#list").append('<table id="data_table"> ');
//                        $("#list").append('<thead>');
//                        $("#list").append('<tr>');
//                        $("#list").append('<th>Id</th>');
//                        $("#list").append('<th>部门名称1</th>');
//                        $("#list").append('<th>备注</th>');
//                        $("#list").append('<th> </th>');
//                        $("#list").append('</tr>');
//                        $("#list").append('</thead>');
//                        $("#list").append('<tbody>');
//                        $("#list").append('<tr>');
//                        $("#list").append('<td>' + item.Id + '</td>');
//                        $("#list").append('<td>' + item.Name + '</td>');
//                        $("#list").append('<td>备注</td>');
//                        $("#list").append('<td>');
//                        $("#list").append('<button class="btn btn-warning" onclick="Edit(' + item.Id + ' );">修改</button>');
//                        $("#list").append('<button class="btn btn-warning" onclick="Edit(' + item.Id + ' );">删除</button>');
//                        $("#list").append('</td>');
//                        $("#list").append('</tr>');
//                        $("#list").append('</tbody>');
//
//                        $("#list").append('<tr>');
//                        $("#list").append('<td>内容</td>');
//                        $("#list").append('<td>' + item.Message + '</td>');
//                        $("#list").append('</tr>');
//                        $("#list").append('</table>');
//                    });
//                    var pageCount = eval("(" + data + ")").pageCount; //取到pageCount的值(把返回数据转成object类型)
//                    var currentPage = eval("(" + data + ")").CurrentPage; //得到urrentPage
//                    var options = {
//                        bootstrapMajorVersion: 2, //版本
//                        currentPage: 10, //当前页数
//                        //currentPage: currentPage, //当前页数
//                        totalPages: 100, //总页数
//                        //totalPages: pageCount, //总页数
//                        itemTexts: function (type, page, current) {
//                            switch (type) {
//                                case "first":
//                                    return "首页";
//                                case "prev":
//                                    return "上一页";
//                                case "next":
//                                    return "下一页";
//                                case "last":
//                                    return "末页";
//                                case "page":
//                                    return page;
//                            }
//                        },
//                        //点击事件，用于通过Ajax来刷新整个list列表
//                        onPageClicked: function (event, originalEvent, type, page) {
//                            $.ajax({
//                                url: "/OA/Setting/GetDate?id=" + page,
//                                type: "Post",
//                                data: "page=" + page,
//                                success: function (data1) {
//                                    if (data1 != null) {
//                                        $.each(eval("(" + data + ")").list, function (index, item) { //遍历返回的json
//                                            $("#list").append('<table id="data_table" class="table table-striped">');
//                                            $("#list").append('<thead>');
//                                            $("#list").append('<tr>');
//                                            $("#list").append('<th>Id</th>');
//                                            $("#list").append('<th>部门名称</th>');
//                                            $("#list").append('<th>备注</th>');
//                                            $("#list").append('<th> </th>');
//                                            $("#list").append('</tr>');
//                                            $("#list").append('</thead>');
//                                            $("#list").append('<tbody>');
//                                            $("#list").append('<tr>');
//                                            $("#list").append('<td>' + item.Id + '</td>');
//                                            $("#list").append('<td>' + item.Name + '</td>');
//                                            $("#list").append('<td>备注</td>');
//                                            $("#list").append('<td>');
//                                            $("#list").append('<button class="btn btn-warning" onclick="Edit(' + item.Id + ' );">修改</button>');
//                                            $("#list").append('<button class="btn btn-warning" onclick="Edit(' + item.Id + ' );">删除</button>');
//                                            $("#list").append('</td>');
//                                            $("#list").append('</tr>');
//                                            $("#list").append('</tbody>');
//
//                                            $("#list").append('<tr>');
//                                            $("#list").append('<td>内容</td>');
//                                            $("#list").append('<td>' + item.Message + '</td>');
//                                            $("#list").append('</tr>');
//                                            $("#list").append('</table>');
//                                        });
//                                    }
//                                }
//                            });
//                        }
//                    };
//                    $('#example').bootstrapPaginator(options);
//                }
//            }
//        });
</script>