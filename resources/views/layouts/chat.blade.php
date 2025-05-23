<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chat App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            font-family: "Poppins", sans-serif;
            background-color: #f0f2f5;
        }

        .sidebar {
            width: 30%;
            max-width: 350px;
            background-color: #f5f7fa;
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1rem;
            background-color: #f5f7fa;
            font-weight: 600;
            font-size: 1.2rem;
            /* border-bottom: 1px solid #dee2e6; */
        }

        .search-box {
            padding: 0.5rem 1rem;
        }

        .search-box input {
            width: 100%;
            padding: 0.5rem;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        .chat-list {
            overflow-y: auto;
            flex-grow: 1;
        }

        .chat-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #dee2e6;
            cursor: pointer;
        }

        .chat-item:hover {
            background-color: #e9ecef;
        }

        .chat-container {
            flex: 1;
            background-color: #f0f2f5;
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chat-card {
            background-color: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 900px;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .chat-header {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .chat-messages {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            background-color: #f9f9fb;
        }

        .message {
            max-width: 60%;
            padding: 0.1rem 1rem;
            border-radius: 15px;
            background-color: #e2e2e2;
            align-self: flex-start;
        }

        .message.sent {
            background-color: #cfe2ff;
            align-self: flex-end;
        }

        .chat-input {
            padding: 0.75rem;
            display: flex;
            gap: 0.5rem;
            border-top: 1px solid #dee2e6;
        }

        .chat-input input {
            flex: 1;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            border: 1px solid #ced4da;
            outline: none;
        }

        .chat-input button {
            background-color: #0d6efd;
            border: none;
            border-radius: 30px;
            color: white;
            padding: 0.5rem 1rem;
        }

        .floating-btn {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background-color: #0d6efd;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            z-index: 9999;
            border: none;
        }

        .contact-menu {
            position: fixed;
            bottom: 90px;
            left: 30px;
            width: 250px;
            z-index: 9998;
            display: none;
        }

        .chat-item-link,
        .user-item a {
            text-decoration: none;
            color: #131111;
        }

        .status-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            left: 30px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .status-indicator.online {
            background-color: #28a745;
        }

        .status-indicator.offline {
            background-color: #dc3545;
        }

        .user-item.opened-chat-header {
            position: relative;
        }

        .opened-chat.user-status {
            position: absolute;
            bottom: 0;
            top: 1.6rem;
            right: 0;
            left: 3.3rem;
            font-size: .7rem;
            color: #7c7f81;
        }

        .opened-chat.title {
            font-weight: 800;
        }

        .user-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .message-header {
            font-size: 0.8rem;
            /* background: #0d6efd */
            /* opacity: 0; */
        }

        .message-header .username {
            font-weight: 800;
            color: #7c0c6d;
            text-overflow: wrap;
        }

        .message-header .phone {
            font-size: 0.7rem;
            color: #7c7f81;
        }

        .message-footer {
            font-size: 0.7rem;
            color: #7c7f81;
            font-family: 'arial';
        }

        .date-separator {
            background-color: #65909e54;
            /* color: #fff; */
            /* height: 1.9rem; */
            /* width: 10rem; */

        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">Mensagens</div>
        <div class="search-box">
            <input type="text" placeholder="Procurar..." />
        </div>
        <div class="chat-list">
            @yield('chat-list')
        </div>
        <!-- <button class="floating-btn"><i class="fas fa-plus"></i></button> -->
        <!-- Floating button -->
        <button class="btn btn-primary rounded-circle floating-btn" id="toggleContacts">
            <i class="fas fa-plus"></i>
        </button>

        <!-- Contact popup -->
        <input type="text" id="user-id" value="{{ $user->id }}" hidden>
        <div class="card contact-menu shadow" id="contactMenu">
            <div class="card-body">
                <h6 class="fw-semibold">Novo Chat</h6>
                <form method="POST" action="/chat/new/" class="newChatForm">
                    @csrf
                    <input class="form-control-sm w-100 mb-2" type="number" placeholder="Telefone" id="phone-number"
                        oninput="changeFormAction(this)" />
                    <button class="btn btn-sm btn-outline-primary w-100 mb-2" type="submit" id="">
                        Iniciar conversa
                    </button>
                </form>

                <button class="btn btn-sm btn-outline-primary w-100 mb-2" id="toggleCreateGroupPopUp">
                    Criar Grupo
                </button>

                <div class="overflow-auto" style="max-height: 300px;">
                    <small class="text-muted">Sugestões</small>
                    @foreach ($users as $user)
                        <div class="user-item d-flex align-items-center my-2 new-chat-user"
                            data-user-phone="{{ $user->phone }}">
                            {{-- <a href="{{ route('chat.new', '$user->phone') }}"> --}}
                            <img src="https://png.pngtree.com/png-vector/20190420/ourmid/pngtree-vector-business-man-icon-png-image_966609.jpg"
                                class="rounded-circle me-2" alt="User" />
                            <span>{{ $user->username === null ? $user->phone : $user->username }}</span>
                            {{-- </a> --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Contact popup -->
        <div class="card contact-menu shadow" id="createGroupMenu">
            <div class="card-body">
                <h6 class="fw-semibold">Criar Grupo</h6>

                <input class="group-name user-input form-control-sm w-100 mb-2" placeholder="Nome do grupo"
                    id="toggleCreateGroupPopUp input" />

                <button href="/chat/new_group/" class="create-group-link btn btn-sm btn-outline-primary w-100 mb-2"
                    id="toggleCreateGroupPopUp">
                    Criar
                </button>
                <div class="overflow-auto" style="max-height: 300px;">
                    
                    <form action="post" action="/group/create" class="new-group-form form d-none">
                        @csrf
                        <input type="text" name="ids" id="users-ids">
                        <input type="text" name="group-name" id="group-name">
                    </form>
                    <small class="text-muted">Sugestões</small>
                    @foreach ($users as $user)
                        <div class="user-item d-flex align-items-center my-2">
                            <input type="checkbox" value="{{ $user->id }}" id="member-checkbox">
                            <img src="https://png.pngtree.com/png-vector/20190420/ourmid/pngtree-vector-business-man-icon-png-image_966609.jpg"
                                class="rounded-circle me-2" alt="User" />
                            <span>{{ $user->username === null ? $user->phone : $user->username }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="chat-container">
        @yield('content')
    </div>
    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
    <script src="/js/onlineUsers.js"></script>
    <script>
        const toggleContacts = document.getElementById("toggleContacts");
        const contactMenu = document.getElementById("contactMenu");
        const createGroupBtn = document.querySelector("#toggleCreateGroupPopUp");
        const createGroupPopup = document.querySelector("#createGroupMenu");
        const newChatForm = document.querySelector(".newChatForm");
        const newChatUser = document.querySelectorAll('.new-chat-user');
        const usersCheckbox = document.querySelectorAll('#member-checkbox');
        const createGroupLinkBtn = document.querySelector('.create-group-link.btn');

        togglePopup(toggleContacts, 'click', contactMenu);
        togglePopup(createGroupBtn, 'click', createGroupPopup);
        hidePopup(toggleContacts, 'click', createGroupPopup);

        document.querySelector('.chat-container').onclick = () => {
            if (createGroupPopup.style.display === 'block') {
                createGroupPopup.style.display = 'none';
            }
        }

        function togglePopup(listener, event = 'click', popup) {
            listener.addEventListener(event, () => {
                popup.style.display =
                    popup.style.display === "block" ? "none" : "block";
            });
        }

        function hidePopup(listener, event = 'click', popup) {
            listener.addEventListener(event, () => {
                popup.style.display = "none";
            });
        }

        function changeFormAction(input) {
            newChatForm.method = 'POST';
            newChatForm.action = `/chat/new/${input.value}`;
        }

        const userPhoneInput = document.querySelector('#phone-number');
        newChatUser.forEach(e => {
            e.addEventListener('click', (event) => {
                // console.log(event.currentTarget)
                const userPhone = Number(event.currentTarget.dataset.userPhone);
                userPhoneInput.value = userPhone;
                newChatForm.action = `/chat/new/${userPhone}`;
                newChatForm.submit();
            })
        });

        let checkedIds = [];
        const groupName = document.querySelector('.group-name.user-input');
        const usersInputIdsForm = document.querySelector('.new-group-form #users-ids');
        const groupNameForm = document.querySelector('.new-group-form #group-name');

        groupName.addEventListener('input', (e) => {
            groupNameForm.value = groupName.value;
        });

        usersCheckbox.forEach(element => {
            element.addEventListener('change', (e) => {
                if (element.checked) {
                    checkedIds.push(element.value);
                    usersInputIdsForm.value = checkedIds;
                    groupNameForm.value = groupName.value;
                }
            })
        });

        createGroupLinkBtn.addEventListener('click', (e) => {
            const form = document.querySelector('.new-group-form.form');
            form.action = '/group/create';
            form.method = 'post';
            form.submit();

            console.log(form)
        })
    </script>
    @yield('socket-listener')
</body>

</html>
