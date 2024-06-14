const httpRequest = async () => {
    const url = 'Admin/notification';
    const request = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    };
    
    
    await fetch(url, request).then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw new Error(data.error || "Unknown error occurred");
            });
        }
        return response.json();
    }).then(response => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 30000,
            timerProgressBar: true,
            customClass: {
              popup: 'my-toast'
            },
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });
          Toast.fire({
            icon: "success",
            title: response.mess
          });
    });
}

window.onload = () => {
    if(!localStorage.getItem('hasSeenNotification')) {
        httpRequest();
        localStorage.setItem('hasSeenNotification', true);
    } else {
        console.log('Notification already seen');
    }
}