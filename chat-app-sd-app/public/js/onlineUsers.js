const userId = document.querySelector("#user-id").value;
const onlineUsersSocket = io("http://127.0.0.1:3000", {
    query: {
        user_id: userId,
    },
});
console.log("listening...");

onlineUsersSocket.on("online_users", (onlineUsers) => {
    console.log(onlineUsers);
    const statusIndicator = document.querySelectorAll(".status-indicator");

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
});
