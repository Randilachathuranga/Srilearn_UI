<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Chat Messages</title>
  <style>
    body {
      font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
      background: #e6eef5; 
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .chat-container {
      width: 100%;
      height: 100vh;
      margin: 0 auto;
      background: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png');
      background-size: contain;
      padding: 0;
      box-shadow: 0 1px 4px rgba(0,0,0,0.2);
      border-radius: 8px;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .chat-header {
      display: flex;
      align-items: center;
      background: #1a75ff;
      color: white;
      padding: 16px 24px;
      height: 70px;
    }

    .header-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #005ce6; 
      margin-right: 20px;
    }

    .header-info {
      flex-grow: 1;
    }

    .header-name {
      margin: 0;
      font-size: 20px;
      font-weight: 500;
    }

    .header-status {
      margin: 0;
      font-size: 15px;
      opacity: 0.8;
    }

    .messages-container {
      flex: 1;
      overflow-y: auto;
      padding: 24px;
    }

    .record {
      position: relative;
      margin-bottom: 16px;
      padding: 12px 16px;
      border-radius: 10px;
      box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
      width: 60%; 
      max-width: 600px;
    }

    .record.sent {
      background-color: #cce6ff; 
      border-right: none;
      align-self: flex-end;
      margin-left: auto;
      border-top-right-radius: 0;
    }

    .record.received {
      background-color: white;
      border-left: none;
      align-self: flex-start;
      margin-right: auto;
      border-top-left-radius: 0;
    }

    .record h3 {
      margin: 0;
      color: #555;
      font-size: 14px;
    }

    .record p {
      margin: 8px 0;
      font-size: 16px;
      line-height: 1.5;
      color: #303030;
      word-wrap: break-word;
    }

    .record h5 {
      margin: 0;
      font-size: 13px;
      color: #8c8c8c;
      text-align: right;
    }

    .message-form {
      display: flex;
      background: #e6eef5; 
      padding: 16px 24px;
      margin-top: 0;
      border-top: none;
      height: 80px;
    }

    .message-input {
      flex: 1;
      padding: 15px 20px;
      border: none;
      border-radius: 24px;
      background: white;
      font-size: 16px;
      resize: none;
    }

    .message-input:focus {
      outline: none;
    }

    .submit-btn {
      width: 50px;
      height: 50px;
      background-color: #1a75ff; 
      color: white;
      border: none;
      border-radius: 50%;
      margin-left: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      padding: 0;
    }

    .submit-btn:hover {
      background-color: #005ce6; 
    }

    .edit-btn {
      position: absolute;
      top: 12px;
      right: 12px;
      background-color: #1a75ff; 
      color: white;
      border: none;
      border-radius: 4px;
      padding: 6px 10px;
      font-size: 13px;
      cursor: pointer;
    }

    .edit-btn:hover {
      background-color: #005ce6; 
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
      padding: 30px;
      border-radius: 12px;
      width: 50%;
      max-width: 700px;
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .modal-header h3 {
      margin: 0;
      color: #1a75ff; 
      font-size: 20px;
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
      padding: 16px;
      border: 1px solid #ddd;
      border-radius: 10px;
      font-size: 16px;
      margin-bottom: 20px;
      resize: none;
      min-height: 120px;
    }

    .edit-input:focus {
      outline: none;
      border-color: #1a75ff; 
    }

    .edit-submit {
      padding: 12px 24px;
      background-color: #1a75ff; 
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      align-self: flex-end;
    }

    .edit-submit:hover {
      background-color: #005ce6; 
    }

    
    .submit-btn::after {
      content: "➤";
      transform: rotate(90deg);
      display: inline-block;
    }
  </style>
</head>
<body>

  <div class="chat-container" id="container">
    <div class="chat-header">
      <div class="header-avatar"></div>
      <div class="header-info">
        <h2 class="header-name">Chat Contact</h2>
        <p class="header-status">online</p>
      </div>
    </div>
    
    <div class="messages-container" id="messages-container"></div>

    <form class="message-form" id="message-form">
      <textarea class="message-input" id="message-input" placeholder="Type a message" required></textarea>
      <button type="submit" class="submit-btn"></button>
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
        let newMessage = document.getElementById('edit-message-input').value.trim();
const tag = '(edited)';


newMessage = newMessage.replace(/\(edited\)/gi, '').trim();


newMessage += ' (edited)';


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

  
  const cleanMessage = messageText.replace(/\(edited\)/gi, '').trim();
  document.getElementById('edit-message-input').value = cleanMessage;

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