const userId = document.querySelector("#user-id").value;
// const webSocketServer = `https://chat-app-sd-websockets.onrender.com`;

const onlineUsersSocket = io("https://chat-app-sd-websockets.onrender.com", {
    query: {
        user_id: userId,
    },
});
console.log("listening...");

onlineUsersSocket.on("online_users", (onlineUsers) => {
    // console.log(onlineUsers);
    const statusIndicator = document.querySelectorAll(".status-indicator");

    //Mas user as online or offline by the green or red dot
    statusIndicator.forEach((statusIndicator) => {
        const classList = [...statusIndicator.classList];
        const userClass = classList.find((htmlClass) =>
            htmlClass.startsWith("user-")
        );

        if (userClass) {
            const userId = parseInt(userClass.replace("user-", ""));

            if (onlineUsers.includes(userId.toString())) {
                statusIndicator.classList.add("online");
                statusIndicator.classList.remove("offline");
            } else {
                statusIndicator.classList.add("offline");
                statusIndicator.classList.remove("online");
            }
        }
    });

    try{
        const openedChatUserStatusUserId = document.querySelector('.opened-chat-header .user-status .user-id').value;
        const openedChatUserStatusText = document.querySelector('.opened-chat-header .user-status .status-text');

        if(onlineUsers.includes(openedChatUserStatusUserId)){
            openedChatUserStatusText.textContent = 'online';
        } else {
            openedChatUserStatusText.textContent = 'offline';
        }
    } catch(err){

    }
});
