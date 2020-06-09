$('.ui.dropdown').dropdown();
for (let form of document.querySelectorAll("form.submit-on-click")) {
  form.onclick = () => {
    form.submit();
  }
}
