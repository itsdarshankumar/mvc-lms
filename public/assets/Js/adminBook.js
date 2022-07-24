function bookName() {
  (async () => {
    const { value: text } = await Swal.fire({
      input: "textarea",
      inputLabel: "Book",
      inputPlaceholder: "Type name of Book",
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
      bookNumber(text);
    }
  })();
}
function searchBook() {
  (async () => {
    const { value: text } = await Swal.fire({
      input: "textarea",
      inputLabel: "Book",
      inputPlaceholder: "Type name of Book",
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
      window.location.href = "/book?search=" + text;
    }
  })();
}

function bookNumber(name) {
  (async () => {
    const { value: number } = await Swal.fire({
      title: "Number of Books?",
      icon: "question",
      input: "range",
      inputLabel: "Number",
      inputAttributes: {
        min: 1,
        max: 200,
        step: 1,
      },
      inputValue: 25,
    });
    if (number) {
      await swal.fire(`${number} books of ${name} were added!!`);
      addBook(name, number);
    }
  })();
}

function addBook(book, number) {
  const json = JSON.stringify({bookname: book,number : number})
  axios
    .post("/book/admin/add", json)
    .then((res) => {
      window.location.href = "/book";
      console.log(res);
    });
}

function userHistory() {
  window.location.href="/book/history"
}


