function loadRequests() {

 fetch("/requests")
 .then(res => res.json())
 .then(data => {

   let html = "";

   data.forEach(r => {

     html += `
       <div style="border:1px solid black; margin:10px; padding:10px">
         <h3>${r.title}</h3>
         <p>${r.description}</p>
         <p>Status: ${r.status}</p>

         <button onclick="approve(${r.id})">Approve</button>
         <button onclick="reject(${r.id})">Reject</button>
       </div>
     `;

   });

   document.getElementById("requests").innerHTML = html;

 });

}

function approve(id){

 fetch("/validation/approve/" + id,{
   method:"POST"
 })
 .then(res => res.text())
 .then(data => {
   alert(data);
   loadRequests();
 });

}

function reject(id){

 fetch("/validation/reject/" + id,{
   method:"POST"
 })
 .then(res => res.text())
 .then(data => {
   alert(data);
   loadRequests();
 });

}