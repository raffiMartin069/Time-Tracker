const notificationQueue = [];

    const showNotification = (message) => {
      return new Promise((resolve) => {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          customClass: {
            popup: 'my-toast'
          },
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          },
          didClose: () => {
            resolve();
          }
        });
        Toast.fire({
          icon: "success",
          title: message
        });
      });
    };

    const processQueue = async () => {
      while (notificationQueue.length > 0) {
        const message = notificationQueue.shift();
        await showNotification(message);
      }
    };

    const httpRequest = async () => {
      const url = 'Admin/notification';
      const request = {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        },
      };

      const response = await fetch(url, request);

      if (!response.ok) {
        const data = await response.json();
        throw new Error(data.error || "Unknown error occurred");
      }

      const responseData = await response.json();

      if (responseData.mess) {
        notificationQueue.push(responseData.mess);
      }

      if (responseData.popup) {
        notificationQueue.push(responseData.popup);
      }

      processQueue();
    };

    window.onload = () => {
      if (!localStorage.getItem('hasSeenNotification')) {
        httpRequest();
        localStorage.setItem('hasSeenNotification', true);
      } else {
        console.log('Notification already seen');
      }
    }