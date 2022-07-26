async function checkId(element, availiable) {
  await confirm(element, availiable);
}
async function getId(element) {
  await checkoutConfirm(element);
}


async function confirm(element, availiable) {
  let result = await Swal.fire({
    title: "Are you sure?",
    text: "You are changing state of this book",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, go ahead!",
  });
  if (result.isConfirmed) {

    if (availiable) {
      availiable = 0;
    } else {
      availiable = 1;
    }
    const json = JSON.stringify({id: element,avail:availiable});
    axios
      .post("/book/admin/update",json)
      .then((res) => {
        if(res.data != 'error'){
        Swal.fire("Done!", "State is now changed.", "success");
        window.location.href = "/book";
      }
      else{
        Swal.fire ('Incorrect...','Book is exhausted!!', 'error')
      }
    });

  }
}

async function checkoutConfirm(element) {
  let result = await Swal.fire({
    title: "Are you sure?",
    text: "You are going to checkout this book",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, go ahead!",
  });
  if (result.isConfirmed) {
    const json = JSON.stringify({bookid: element});
   await axios
      .post("/book", json)
      .then((res) => {
        console.log(res);
        if(res.data != "error"){
          Swal.fire("Done!", "Successful checkout.", "success");}
          else{
            Swal.fire ('Incorrect...','You already have this book!', 'error')
          }
      });
      
  }
}


function confirmFilter(){
  (async () => {

    const inputOptions = new Promise((resolve) => {
      setTimeout(() => {
        resolve({
          1:'Accepted',
          3:'Returned',
          0:'Rejected',
          2:'Pending'
        })
      }, 0)
    })
    
    const { value: filter } = await Swal.fire({
      title: 'Select filter',
      input: 'radio',
      inputOptions: inputOptions,
      inputValidator: (value) => {
        if (!value) {
          return 'You need to choose something!'
        }
      }
    })
    
    if (filter) {
      window.location.href="/book/history?filter="+filter
    }
    
    })()
}
async function returnRequest(id) {
  let result = await Swal.fire({
    title: "Are you sure?",
    text: "You are returning this book!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, go ahead!",
  });
  if (result.isConfirmed) {

    Swal.fire("Done!", "Successful granted.", "success");
    const json = JSON.stringify({id: id});
    await axios
    .post("/book/return", json)
    .then((res) => {
      window.location.href = "/book";
    });

  }
}



