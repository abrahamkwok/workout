var mysql = require('mysql');

function hi() {
    alert("hi");
}

var con = mysql.createConnection({
  host: "localhost",
  user: "sqluser",
  password: "ninja123",
  database: "abe"
});

function ClearFields() {

  document.getElementById("exercise").value = "";
  document.getElementById("weight").value = "";
  document.getElementById("sets").value = "";
  document.getElementById("reps").value = "";
}

function insertion() {
  con.connect(function(err) {
    if (err) throw err;
    console.log("Connected!");

    var sql = "INSERT INTO student (name, major) VALUES ('', 'test')";
    con.query(sql, function (err, result) {
      if (err) throw err;
      console.log("1 record inserted");
    });

  });
}