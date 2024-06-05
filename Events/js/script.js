window.onload = function () {
  fetch('data/events.json')
    .then(response => response.json())
    .then(data => {
      const eventsContainer = document.getElementById('events');
      data.forEach(event => {
        const eventCard = document.createElement('div');
        eventCard.className = 'event-card';
        eventCard.innerHTML = `
              <img src="${event.image}" alt="Изображение мероприятия" class="event-image">
              <h2>${event.name}</h2>
              <p><strong>Дата:</strong> ${event.date} <strong>Время:</strong> ${event.time}</p>
              <p><strong>Место:</strong> ${event.place}</p>
              <p><strong>Доступно:</strong> ${event.available}</p>
          `;
        eventsContainer.appendChild(eventCard);
      });
    });
};
