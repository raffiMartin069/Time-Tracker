(() => {
    document.addEventListener('DOMContentLoaded', () => {
        const logOut = document.getElementById('log-out');

        if (logOut) {
            logOut.addEventListener('submit', async (e) => {
                e.preventDefault();

                // Clear local storage
                localStorage.clear();

                try {
                    // Perform the fetch request
                    const response = await fetch(logOut.action, {
                        method: logOut.method,
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ logoutBtn: 1 })  // Ensure this matches the expected value
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const responseData = await response.json();
                    
                    // Redirect to the URL received in the response
                    window.location.href = responseData.url;
                } catch (error) {
                    console.error('Fetch error:', error);
                }
            });
        }
    });
})();