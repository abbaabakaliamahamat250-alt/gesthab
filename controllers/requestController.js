const model = require("../models/requestModel");

exports.getRequests = (req, res) => {
  model.getAllRequests((err, results) => {
    if (err) {
      res.status(500).send(err);
    } else {
      res.json(results);
    }
  });
};

exports.createRequest = (req, res) => {
  const { title, description, user_id } = req.body;

  model.createRequest(title, description, user_id, (err, result) => {
    if (err) {
      res.status(500).send(err);
    } else {
      res.send("Request created");
    }
  });
};