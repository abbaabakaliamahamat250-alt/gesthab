const db = require("../config/db");

exports.getAllRequests = (callback) => {
  db.query("SELECT * FROM requests", callback);
};

exports.createRequest = (title, description, user_id, callback) => {
  db.query(
    "INSERT INTO requests (title, description, user_id) VALUES (?, ?, ?)",
    [title, description, user_id],
    callback
  );
};

exports.getRequestById = (id, callback) => {
  db.query("SELECT * FROM requests WHERE id=?", [id], callback);
};

exports.updateStep = (id, callback) => {
  db.query(
    "UPDATE requests SET current_step = current_step + 1 WHERE id=?",
    [id],
    callback
  );
};

exports.approveRequest = (id, callback) => {
  db.query(
    "UPDATE requests SET status='approved' WHERE id=?",
    [id],
    callback
  );
};

exports.rejectRequest = (id, callback) => {
  db.query(
    "UPDATE requests SET status='rejected' WHERE id=?",
    [id],
    callback
  );
};