document.addEventListener('DOMContentLoaded', function () {
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message');
    const chatMessages = document.getElementById('chat-messages');
    const userList = document.getElementById('userlist');

    // Set status to active when page is loaded
    fetch('php/setstatus.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'status=active'
    });

    // 1. Send message via AJAX
    chatForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const message = messageInput.value.trim();
        if (!message) return;

        const formData = new FormData();
        formData.append('message', message);

        fetch('php/sendmessage.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error("Failed to send");
            messageInput.value = '';
            loadMessages(); // Refresh chat after sending
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Could not send message.");
        });
    });

    // 2. Load chat messages from DB
    function loadMessages() {
        fetch('php/fetchmessages.php')
            .then(res => res.json())
            .then(data => {
                chatMessages.innerHTML = ''; // Clear existing

                data.forEach(msg => {
                    const msgDiv = document.createElement('div');
                    msgDiv.classList.add('message');
                    if (msg.is_self) msgDiv.classList.add('self');

                    msgDiv.innerHTML = `
                        <img src="uploads/${msg.profile_pic}" class="profile-pic" alt="${msg.username}">
                        <div class="message-content">
                            <span class="username">${msg.username}</span>
                            <p>${msg.message}</p>
                        </div>
                    `;
                    chatMessages.appendChild(msgDiv);
                });

                chatMessages.scrollTop = chatMessages.scrollHeight;
            })
            .catch(err => console.error("Error loading messages:", err));
    }

    // 3. Load active/inactive users
    function loadUsers() {
        fetch('php/fetchusers.php')
            .then(res => res.json())
            .then(users => {
                userList.innerHTML = ''; // Clear current

                users.forEach(user => {
                    const li = document.createElement('li');
                    const statusClass = user.status === 'active' ? 'online' : 'offline';

                    li.innerHTML = `<span class="status ${statusClass}"></span> ${user.username}`;
                    userList.appendChild(li);
                });
            })
            .catch(err => console.error("Error loading users:", err));
    }

    // 4. Auto-refresh messages and users every 5 seconds
    loadMessages();
    loadUsers();
    setInterval(() => {
        loadMessages();
        loadUsers();
    }, 5000);
});

// Set status to inactive when tab or window is closed
window.addEventListener('beforeunload', function () {
    navigator.sendBeacon('php/setstatus.php', new URLSearchParams({
        status: 'inactive'
    }));
});
