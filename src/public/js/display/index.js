var divContainer = "#DisplayTableContainer";

$(document).ready(function () {
  $(divContainer).jtable({
    title: "",
    jqueryuiTheme: true,
    pageSize: 20,
    paging: true,
    sorting: false,
    pageSizeChangeArea: false,
    columnSelectable: false,
    columnResizable: false,
    gotoPageArea: false,
    openChildAsAccordion: true,
    actions: {
      listAction: "/api/display/getData/list?_token=" + tokenValList,
    },
    fields: {
      id: {
        key: true,
        create: false,
        edit: false,
        list: true,
        width: "2%",
        title: "Id",
      },
      name: {
        title: "Name",
        width: "20%",
      },
      imageUrl: {
        title: "Url",
		width: "20%",
		display: function (data) {
			return '<a href="'+ data.record.imageUrl +'" target="_blank"><b>'+ data.record.name +'</b></a> ';
		}
      }
    },
  });

  initComboBox();

});

function initComboBox() {
  $("#txtUser").on("change", function change() {
    var url = "/displayfiles?u=" + $(this).val(); // get selected value
    if (url) {
      // require a URL
      window.location = url; // redirect
    }
    return false;
  });
  $("#txtDate").on("change", function change() {

    if(!isBlank($("#txtDate").val())){
      $(divContainer).jtable("load", {
        userId: $("#txtUser").val(),
        date: $("#txtDate").val(),
      });
    }
    
  });

  setInterval(function () {
    
    if(!isBlank($("#txtDate").val())){
      $(divContainer).jtable("load", {
        userId: $("#txtUser").val(),
        date: $("#txtDate").val(),
      });
    }
    
  }, 20000); // 20 seconds

}
function isBlank(str) {
  return !str || /^\s*$/.test(str);
}
