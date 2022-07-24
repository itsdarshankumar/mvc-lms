async function checkId(element, availiable) {
  await confirm(element, availiable);
}
async function getId(element) {
  await checkoutConfirm(element);
}

function postState(element, availiable) {
  if (availiable) {
    availiable = 0;
  } else {
    availiable = 1;
  }
  const json = JSON.stringify({id: element,avail:availiable});
  axios
    .post("/book/admin/update",json)
    .then((res) => {
      console.log(res);
      window.location.href = "/book";
    });
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

    Swal.fire("Done!", "State is now changed.", "success");
    postState(element, availiable);
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

    Swal.fire("Done!", "Successful checkout.", "success");
    checkout(element);
  }
}

function checkout(element) {
  console.log(element)
  const json = JSON.stringify({bookid: element});
  axios
    .post("/book", json)
    .then((res) => {
      console.log(res);
    });
}
