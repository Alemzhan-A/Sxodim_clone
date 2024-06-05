window.onload = function () {
  const urlParams = new URLSearchParams(window.location.search);
  const message = urlParams.get('message');
  const reason = urlParams.get('reason');

  if (message) {
    const messageText = document.getElementById('message-text');
    const modal = document.getElementById('message-modal');
    const closeModal = document.getElementsByClassName('close')[0];

    if (message === 'success') {
      messageText.innerText = 'Регистрация успешна! Добро пожаловать!';
    } else if (message === 'error') {
      messageText.innerText = `Ошибка: ${reason}`;
    }

    modal.style.display = 'block';

    closeModal.onclick = function () {
      modal.style.display = 'none';
    };

    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = 'none';
      }
    };
  }
};
