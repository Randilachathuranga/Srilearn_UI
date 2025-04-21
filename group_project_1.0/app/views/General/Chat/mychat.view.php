<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Chat Messages</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    .chat-container {
      max-width: 700px;
      margin: 40px auto;
      background: white;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      display: flex;
      flex-direction: column;
    }

    .messages-container {
      max-height: 500px;
      overflow-y: auto;
      margin-bottom: 20px;
    }

    .record {
      background-color: #e9f5ff;
      margin-bottom: 15px;
      padding: 10px 15px;
      border-radius: 5px;
      width: 80%;
      position: relative;
    }

    .record.sent {
      background-color: #e1f7e1;
      border-right: 4px solid #2ecc71;
      align-self: flex-end;
      margin-left: auto;
    }

    .record.received {
      border-left: 4px solid #3498db;
      align-self: flex-start;
      margin-right: auto;
    }

    .record h3 {
      margin: 0;
      color: #555;
      font-size: 14px;
    }

    .record p {
      margin: 5px 0;
      font-size: 16px;
      color: #222;
      word-wrap: break-word;
    }

    .record h5 {
      margin: 0;
      font-size: 12px;
      color: #999;
      text-align: right;
    }

    .message-form {
      display: flex;
      margin-top: 20px;
      border-top: 1px solid #eee;
      padding-top: 20px;
    }

    .message-input {
      flex: 1;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
      resize: none;
    }

    .submit-btn {
      padding: 12px 24px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 4px;
      margin-left: 10px;
      cursor: pointer;
      font-size: 16px;
    }

    .submit-btn:hover {
      background-color: #2980b9;
    }

    .edit-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #f39c12;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 4px 8px;
      font-size: 12px;
      cursor: pointer;
    }

    .edit-btn:hover {
      background-color: #e67e22;
    }

    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      width: 80%;
      max-width: 500px;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .modal-header h3 {
      margin: 0;
      color: #333;
    }

    .close-modal {
      background: none;
      border: none;
      font-size: 24px;
      cursor: pointer;
      color: #777;
    }

    .edit-form {
      display: flex;
      flex-direction: column;
    }

    .edit-input {
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
      margin-bottom: 15px;
      resize: none;
      min-height: 100px;
    }

    .edit-submit {
      padding: 12px 24px;
      background-color: #2ecc71;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      align-self: flex-end;
    }

    .edit-submit:hover {
      background-color: #27ae60;
    }
  </style>
</head>
<body>

  <div class="chat-container" id="container">
    <div class="messages-container" id="messages-container"></div>

    <form class="message-form" id="message-form">
      <textarea class="message-input" id="message-input" placeholder="Type your message here..." required></textarea>
      <button type="submit" class="submit-btn">Send</button>
    </form>
  </div>

  <div class="modal" id="edit-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Edit Message</h3>
        <button class="close-modal" id="close-modal">&times;</button>
      </div>
      <form class="edit-form" id="edit-form">
        <input type="hidden" id="edit-message-id">
        <textarea class="edit-input" id="edit-message-input" required></textarea>
        <button type="submit" class="edit-submit">Update Message</button>
      </form>
    </div>
  </div>

  <script>
    const currentUserId = <?php echo $_SESSION['User_id']; ?>;
    const receiverId = <?php echo json_encode($data['id']); ?>;

    document.addEventListener('DOMContentLoaded', () => {
      loadMessages();

      document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value.trim();

        if (message) {
          const now = new Date();
          const recordData = {
            sender_id: currentUserId,
            reciever_id: receiverId,
            message: message,
            date: now.toISOString().split('T')[0],
            time: now.toTimeString().split(' ')[0]
          };

          fetch('http://localhost/group_project_1.0/public/Chat/post', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(recordData)
          })
          .then(response => {
            if (!response.ok) throw new Error('Failed to send message');
            return response.json();
          })
          .then(data => {
            messageInput.value = '';
            loadMessages();
          })
          .catch(error => {
            console.error('Error sending message:', error);
          });
        }
      });

      const modal = document.getElementById('edit-modal');
      const closeModalBtn = document.getElementById('close-modal');

      closeModalBtn.addEventListener('click', () => modal.style.display = 'none');
      window.addEventListener('click', (e) => {
        if (e.target === modal) modal.style.display = 'none';
      });

      document.getElementById('edit-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const messageId = document.getElementById('edit-message-id').value;
        const newMessage = document.getElementById('edit-message-input').value.trim();

        if (newMessage) {
          fetch(`http://localhost/group_project_1.0/public/Chat/edit/${messageId}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
              msg_id: messageId,
              message: newMessage,
              reciever_id: receiverId,
            })
          })
          .then(response => {
            if (!response.ok) throw new Error('Failed to update message');
            return response.json();
          })
          .then(data => {
            loadMessages();
            setTimeout(() => {
              modal.style.display = 'none';
            }, 100);
          })
          .catch(error => {
            console.error('Error updating message:', error);
          });
        }
      });
    });

    function loadMessages() {
      fetch(`http://localhost/group_project_1.0/public/Chat/${receiverId}`)
        .then(response => {
          if (!response.ok) throw new Error('Network response was not ok');
          return response.json();
        })
        .then(data => {
          const container = document.getElementById('messages-container');
          container.innerHTML = '';
          data.forEach(record => {
            appendMessage(record);
          });
          container.scrollTop = container.scrollHeight;
        })
        .catch(error => {
          console.error('Error loading messages:', error);
        });
    }

    function appendMessage(record) {
      const container = document.getElementById('messages-container');
      const rec = document.createElement('div');
      const isSent = record.sender_id == currentUserId;
      const msgId = record.msg_id || Date.now();
      const escapedMsg = escapeHtml(record.message);

      rec.className = `record ${isSent ? 'sent' : 'received'}`;
      rec.setAttribute('data-message-id', msgId);

      rec.innerHTML = `
        <h3>${record.date}</h3>
        <p>${escapedMsg}</p>
        <h5>${record.time}</h5>
        ${isSent ? `<button class="edit-btn" onclick="openEditModal('${msgId}', \`${escapedMsg}\`)">Edit</button>` : ''}
      `;

      container.appendChild(rec);
    }

    function openEditModal(messageId, messageText) {
      document.getElementById('edit-message-id').value = messageId;
      document.getElementById('edit-message-input').value = messageText;
      document.getElementById('edit-modal').style.display = 'flex';
    }

    function escapeHtml(text) {
      return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    }
  </script>

</body>
</html>
