$(document).ready(function(){$(".right a.btn").click(function(a){a.preventDefault();var b=$(this),c=$(".coauthor.base").clone().removeClass("base");c.find("input").each(function(){var a=$(this).attr("id"),b=$(this).attr("name"),c=$(this).siblings("label");console.log(a,b,c)})})});