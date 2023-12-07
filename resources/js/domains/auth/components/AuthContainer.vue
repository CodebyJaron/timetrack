<template>
    <div class="auth-container">
        <div class="login-card">
            <slot />
        </div>
    </div>
</template>

<style scoped lang="scss">
.auth-container {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;

    .login-card {
        width: 100%;
        max-width: 500px;
        padding: 1rem 2rem;
        margin: auto;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 50px rgba(0, 0, 0, 0.075);
    }
}
</style>
