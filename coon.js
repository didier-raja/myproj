const express = require('express');
const mysql = require('mysql2');

const app = express();
const port = 3000;

// MySQL connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',     // your DB username
  password: '',     // your DB password
});

// Connect to MySQL
db.connect((err) => {
  if (err) {
    console.error('Error connecting to MySQL:', err.message);
    return;
  }
  console.log('Connected to MySQL');

  // Create database
  db.query('CREATE DATABASE IF NOT EXISTS mydatabase', (err, result) => {
    if (err) throw err;
    console.log('Database created or already exists');
  });
});

app.get('/', (req, res) => {
  res.send('Hello Express + MySQL!');
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
