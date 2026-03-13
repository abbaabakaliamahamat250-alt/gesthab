const model = require("../models/requestModel");

exports.approve = (req, res) => {

  const id = req.params.id;

  model.getRequestById(id, (err, result) => {

    if (err) return res.status(500).send(err);

    const request = result[0];

    if (!request) {
      return res.send("Request not found");
    }

    if (request.current_step < 3) {

      model.updateStep(id, (err) => {
        if (err) return res.status(500).send(err);

        res.send("Moved to next manager");
      });

    } else {

      model.approveRequest(id, (err) => {
        if (err) return res.status(500).send(err);

        res.send("Request fully approved");
      });

    }

  });

};

exports.reject = (req, res) => {

  const id = req.params.id;

  model.rejectRequest(id, (err) => {
    if (err) return res.status(500).send(err);

    res.send("Request rejected");
  });

};