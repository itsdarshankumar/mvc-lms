async function denyId(element, bookID) {
  await denyConfirm(element, bookID);
}
async function acceptId(element, bookID) {
  console.log(element);
  await acceptConfirm(element, bookID);
}

function denyPost(element, bookID) {
  axios
    .post("/book/admin", {
      id: element,
      status: 0,
      bookid: bookID,
    })
    .then((res) => {
      console.log(res);
      window.location.href = "/book/admin";
    });
}

async function denyConfirm(element, bookID) {
  let result = await Swal.fire({
    title: "Are you sure?",
    text: "You are declining this request",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, go ahead!",
  });
  if (result.isConfirmed) {

    Swal.fire("Done!", "Request declined", "success");
    denyPost(element, bookID);
  }
}

async function acceptConfirm(element, bookID) {
  let result = await Swal.fire({
    title: "Are you sure?",
    text: "You are accepting this request",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, go ahead!",
  });
  if (result.isConfirmed) {
    console.log("permission granted");

    Swal.fire("Done!", "Successful granted.", "success");
    acceptPost(element, bookID);
  }
}

function acceptPost(element, bookID) {
  console.log("request");
  axios
    .post("/book/admin", {
      id: element,
      status: 1,
      bookid: bookID,
    })
    .then((res) => {
      console.log(res);
      window.location.href = "/book/admin";
    });
}
document.getElementById("filter").addEventListener("click", requestSearch);
function requestSearch() {
  (async () => {
    const { value: text } = await Swal.fire({
      input: "textarea",
      inputLabel: "Book",
      inputPlaceholder: "Type name of User",
      inputAttributes: {
        "aria-label": "Type your message here",
      },
      showCancelButton: true,
      inputValidator: (value) => {
        if (!value) {
          return "You need to write something!";
        }
      },
    });
    if (text) {
      window.location.href =
        "/book/admin/history?username=" + text;
    }
  })();
}

async function returned(element, bookin) {
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
    console.log("permission granted");

    Swal.fire("Done!", "Successful granted.", "success");
    returnPost(element,bookin);
  }
}

function returnPost(element, bookin) {
  axios
    .post("/book/admin/return", {
      id: element,
      bookid: bookin,
    })
    .then((res) => {
      window.location.href = "/book/admin";
    });
}
