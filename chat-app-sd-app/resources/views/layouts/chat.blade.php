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
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            padding: 0.75rem 1rem;
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

        .user-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
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
        <div class="card contact-menu shadow" id="contactMenu">
            <div class="card-body">
                <h6 class="fw-semibold">Novo Chat</h6>
                <form action="/chat/new/" method="POST" class="newChatForm">
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

                <div>
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
                <input class="form-control-sm w-100 mb-2" placeholder="Nome do grupo" id="toggleCreateGroupPopUp" />
                <a href="{{ route('group.new', 'Informatica 2022 - 4 Ano') }}"
                    class="btn btn-sm btn-outline-primary w-100 mb-2" id="toggleCreateGroupPopUp">
                    Criar
                </a>
                <div>
                    <small class="text-muted">Sugestões</small>
                    <div class="user-item d-flex align-items-center my-2">
                        <input type="checkbox" value="Dosha" id="member-checkbox">
                        <img src="https://png.pngtree.com/png-vector/20190420/ourmid/pngtree-vector-business-man-icon-png-image_966609.jpg"
                            class="rounded-circle me-2" alt="User" />
                        <span>Dosha</span>
                    </div>
                    <div class="user-item d-flex align-items-center my-2">
                        <input type="checkbox" value="Mike" id="member-checkbox">
                        <img src="https://png.pngtree.com/png-vector/20190420/ourmid/pngtree-vector-business-man-icon-png-image_966609.jpg"
                            class="rounded-circle me-2" alt="User" />
                        <span>Mike</span>
                    </div>
                    <div class="user-item d-flex align-items-center my-2">
                        <input type="checkbox" value="Tina" id="member-checkbox">
                        <img src="https://png.pngtree.com/png-vector/20190420/ourmid/pngtree-vector-business-man-icon-png-image_966609.jpg"
                            class="rounded-circle me-2" alt="User" />
                        <span>Tina</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="chat-container">
        @yield('content')
    </div>

    <script>
        const toggleContacts = document.getElementById("toggleContacts");
        const contactMenu = document.getElementById("contactMenu");
        const createGroupBtn = document.querySelector("#toggleCreateGroupPopUp");
        const createGroupPopup = document.querySelector("#createGroupMenu");
        const newChatForm = document.querySelector(".newChatForm");
        const newChatUser = document.querySelectorAll('.new-chat-user');

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
            newChatForm.action = `/chat/new/${input.value}`;
        }

        const userPhoneInput = document.querySelector('#phone-number');
        newChatUser.forEach(e => {
            e.addEventListener('click', (event) => {
                const userPhone = Number(event.target.dataset.userPhone);
                userPhoneInput.value = userPhone;
                newChatForm.action = `/chat/new/${userPhone}`;
                newChatForm.submit();
            })
        });
    </script>
    @yield('socket-listener')
</body>

</html>
