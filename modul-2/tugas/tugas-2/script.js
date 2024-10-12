// Fungsi untuk meminta izin notifikasi
function requestNotificationPermission() {
    if (Notification.permission === "default") {
        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                console.log("Izin notifikasi diberikan.");
            } else {
                console.log("Izin notifikasi ditolak.");
            }
        });
    }
}

// Fungsi untuk mengirimkan notifikasi
function sendNotification(taskTitle, taskText) {
    if (Notification.permission === "granted") {
        new Notification(taskTitle, {
            body: `Jangan lupa untuk menyelesaikan: ${taskText}`,
            icon: "./assets/lkmstn.jpg" 
        });
    }
}

// Fungsi add tasks to list
document.getElementById('add-task').addEventListener('click', function() {
    const taskTitleInput = document.getElementById('new-title-task');
    const taskInput = document.getElementById('new-task');
    const taskDateInput = document.getElementById('task-date');

    const taskTitle = taskTitleInput.value.trim();
    const taskText = taskInput.value.trim();
    const taskDate = taskDateInput.value;

    if (taskTitle !== "" && taskText !== "" && taskDate !== "") {
        addTask(taskTitle, taskText, taskDate);
        taskTitleInput.value = "";
        taskInput.value = "";
        taskDateInput.value = "";
    } else {
        alert("Please fill in all fields (title, task, and date-time).");
    }
});

// Fungsi add task & add to schedule notif
function addTask(taskTitle, taskText, taskDate) {
    const taskList = document.getElementById('task-list');

    const li = document.createElement('li');

    const taskInfo = document.createElement('div');
    taskInfo.className = 'task-info';
    taskInfo.innerHTML = `<strong>${taskTitle}</strong>: ${taskText} <br> <small>${taskDate}</small>`;

    const deleteBtn = document.createElement('button');
    deleteBtn.textContent = 'Delete';
    deleteBtn.className = 'delete-btn';

    li.appendChild(taskInfo);
    li.appendChild(deleteBtn);

    taskList.appendChild(li);

    deleteBtn.addEventListener('click', function() {
        taskList.removeChild(li);
    });

    // Jadwalkan notifikasi sesuai dengan waktu yang diatur
    scheduleNotification(taskTitle, taskText, taskDate);
}

// Fungsi untuk menjadwalkan notifikasi
function scheduleNotification(taskTitle, taskText, taskDate) {
    const now = new Date(); // Waktu saat ini
    const taskDateTime = new Date(taskDate); // Waktu tugas yang dipilih

    const timeDifference = taskDateTime - now; // Selisih waktu antara sekarang dan waktu tugas

    if (timeDifference > 0) {
        // Jadwalkan notifikasi jika waktunya belum berlalu
        console.log(`Notifikasi akan dikirim dalam ${timeDifference / 1000} detik.`);
        setTimeout(() => {
            sendNotification(taskTitle, taskText); // Kirim notifikasi
        }, timeDifference);
    } else {
        console.log("Waktu tugas telah berlalu, tidak dapat menjadwalkan notifikasi.");
    }
}

// Meminta izin notifikasi saat halaman dimuat
requestNotificationPermission();
