!function(e){var t={};function n(a){if(t[a])return t[a].exports;var o=t[a]={i:a,l:!1,exports:{}};return e[a].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(a,o,function(t){return e[t]}.bind(null,o));return a},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=5)}({5:function(e,t,n){e.exports=n("JLaZ")},JLaZ:function(e,t){var n;(n=window.jQuery)(function(){var e=n("#dtable"),t=e.data("model"),a=n("#save_completed"),o=n("#completed_count"),c=[];n(document).on("change",".completed",function(){this.checked?c.push(this.value):c=_.without(c,this.value),o.html(c.length),c.length?a.css("display","inline-block"):a.css("display","none")}),a.on("click",function(){alert("In progress..."),window.toastr.success("Atlikti darbai išsaugoti"),n(".completed").prop("checked",!1),c=[],a.css("display","none")}),e.length&&e.DataTable({ajax:"".concat(t,"/json"),processing:!0,serverSide:!0,responsive:!0,searching:!0,dom:"<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",lengthMenu:[5,10,25,50],pageLength:10,order:[],language:{lengthMenu:"Rodyti _MENU_"},rowCallback:function(e,t){t.DT_RowData.special&&n(e).addClass("table-success"),t.DT_RowData.late&&n(e).addClass("table-warning")},columnDefs:[{targets:0,title:"Objektas",orderable:!1,className:"",type:"html",render:function(e,t,n){return'\n                                <a href="/contracts/'.concat(n.DT_RowData.contractid,"/objects/").concat(n.DT_RowData.objectid,'/edit">').concat(e,"</a>\n                            ")}},{targets:3,title:"Darbas",orderable:!1,className:"",type:"html",render:function(e,t,n){return'\n                                <a href="/contracts/'.concat(n.DT_RowData.contractid,"/objects/").concat(n.DT_RowData.objectid,"/tasks/").concat(n.DT_RowData.taskid,'/edit">').concat(e,"</a>\n                            ")}},{targets:-1,title:"Veiksmai",orderable:!1,className:"text-center",type:"html",render:function(e,t,n){return'\n                                <label class="kt-checkbox">\n                                    <input class="completed" type="checkbox" name="completed[]" value="'.concat(n.DT_RowData.taskid,'"> &nbsp;\n                                    <span></span>\n                                </label>\n                            ')}}]})})}});