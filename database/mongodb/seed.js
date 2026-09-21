// Run: mongosh student_portfolio database/mongodb/seed.js
// Run `php database/seed.php` afterwards to create the password-hashed admin
// and matching project/skill samples through the PHP repository layer.
db.projects.createIndex({created_at:-1});
db.contacts.createIndex({email:1});
db.admins.createIndex({username:1},{unique:true});
db.skills.insertMany([{name:'PHP',category:'Backend',proficiency:88,sort_order:1},{name:'JavaScript',category:'Frontend',proficiency:82,sort_order:2},{name:'MongoDB',category:'Database',proficiency:76,sort_order:3},{name:'MySQL',category:'Database',proficiency:80,sort_order:4},{name:'Git & GitHub',category:'Tools',proficiency:85,sort_order:5}]);
