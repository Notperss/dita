const Ziggy = {
    url: "http://localhost",
    port: null,
    defaults: {},
    routes: {
        login: { uri: "login", methods: ["GET", "HEAD"] },
        logout: { uri: "logout", methods: ["POST"] },
        "password.request": {
            uri: "forgot-password",
            methods: ["GET", "HEAD"],
        },
        "password.reset": {
            uri: "reset-password/{token}",
            methods: ["GET", "HEAD"],
            parameters: ["token"],
        },
        "password.email": { uri: "forgot-password", methods: ["POST"] },
        "password.update": { uri: "reset-password", methods: ["POST"] },
        register: { uri: "register", methods: ["GET", "HEAD"] },
        "user-profile-information.update": {
            uri: "user/profile-information",
            methods: ["PUT"],
        },
        "user-password.update": { uri: "user/password", methods: ["PUT"] },
        "password.confirmation": {
            uri: "user/confirmed-password-status",
            methods: ["GET", "HEAD"],
        },
        "password.confirm": { uri: "user/confirm-password", methods: ["POST"] },
        "two-factor.login": {
            uri: "two-factor-challenge",
            methods: ["GET", "HEAD"],
        },
        "two-factor.enable": {
            uri: "user/two-factor-authentication",
            methods: ["POST"],
        },
        "two-factor.confirm": {
            uri: "user/confirmed-two-factor-authentication",
            methods: ["POST"],
        },
        "two-factor.disable": {
            uri: "user/two-factor-authentication",
            methods: ["DELETE"],
        },
        "two-factor.qr-code": {
            uri: "user/two-factor-qr-code",
            methods: ["GET", "HEAD"],
        },
        "two-factor.secret-key": {
            uri: "user/two-factor-secret-key",
            methods: ["GET", "HEAD"],
        },
        "two-factor.recovery-codes": {
            uri: "user/two-factor-recovery-codes",
            methods: ["GET", "HEAD"],
        },
        "profile.show": { uri: "user/profile", methods: ["GET", "HEAD"] },
        "sanctum.csrf-cookie": {
            uri: "sanctum/csrf-cookie",
            methods: ["GET", "HEAD"],
        },
        "livewire.update": { uri: "livewire/update", methods: ["POST"] },
        "livewire.upload-file": {
            uri: "livewire/upload-file",
            methods: ["POST"],
        },
        "livewire.preview-file": {
            uri: "livewire/preview-file/{filename}",
            methods: ["GET", "HEAD"],
            parameters: ["filename"],
        },
        "ignition.healthCheck": {
            uri: "_ignition/health-check",
            methods: ["GET", "HEAD"],
        },
        "ignition.executeSolution": {
            uri: "_ignition/execute-solution",
            methods: ["POST"],
        },
        "ignition.updateConfig": {
            uri: "_ignition/update-config",
            methods: ["POST"],
        },
        "dashboard.index": {
            uri: "/dashboard",
            methods: ["GET", "HEAD"],
        },
        "dashboard.create": {
            uri: "/dashboard/create",
            methods: ["GET", "HEAD"],
        },
        "dashboard.store": { uri: "/dashboard", methods: ["POST"] },
        "dashboard.show": {
            uri: "/dashboard/{dashboard}",
            methods: ["GET", "HEAD"],
            parameters: ["dashboard"],
        },
        "dashboard.edit": {
            uri: "/dashboard/{dashboard}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["dashboard"],
        },
        "dashboard.update": {
            uri: "/dashboard/{dashboard}",
            methods: ["PUT", "PATCH"],
            parameters: ["dashboard"],
        },
        "dashboard.destroy": {
            uri: "/dashboard/{dashboard}",
            methods: ["DELETE"],
            parameters: ["dashboard"],
        },
        "main-location.index": {
            uri: "/main-location",
            methods: ["GET", "HEAD"],
        },
        "main-location.create": {
            uri: "/main-location/create",
            methods: ["GET", "HEAD"],
        },
        "main-location.store": {
            uri: "/main-location",
            methods: ["POST"],
        },
        "main-location.show": {
            uri: "/main-location/{main_location}",
            methods: ["GET", "HEAD"],
            parameters: ["main_location"],
        },
        "main-location.edit": {
            uri: "/main-location/{main_location}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["main_location"],
        },
        "main-location.update": {
            uri: "/main-location/{main_location}",
            methods: ["PUT", "PATCH"],
            parameters: ["main_location"],
        },
        "main-location.destroy": {
            uri: "/main-location/{main_location}",
            methods: ["DELETE"],
            parameters: ["main_location"],
        },
        "sub-location.index": {
            uri: "/sub-location",
            methods: ["GET", "HEAD"],
        },
        "sub-location.create": {
            uri: "/sub-location/create",
            methods: ["GET", "HEAD"],
        },
        "sub-location.store": {
            uri: "/sub-location",
            methods: ["POST"],
        },
        "sub-location.show": {
            uri: "/sub-location/{sub_location}",
            methods: ["GET", "HEAD"],
            parameters: ["sub_location"],
        },
        "sub-location.edit": {
            uri: "/sub-location/{sub_location}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["sub_location"],
        },
        "sub-location.update": {
            uri: "/sub-location/{sub_location}",
            methods: ["PUT", "PATCH"],
            parameters: ["sub_location"],
        },
        "sub-location.destroy": {
            uri: "/sub-location/{sub_location}",
            methods: ["DELETE"],
            parameters: ["sub_location"],
        },
        "detail-location.index": {
            uri: "/detail-location",
            methods: ["GET", "HEAD"],
        },
        "detail-location.create": {
            uri: "/detail-location/create",
            methods: ["GET", "HEAD"],
        },
        "detail-location.store": {
            uri: "/detail-location",
            methods: ["POST"],
        },
        "detail-location.show": {
            uri: "/detail-location/{detail_location}",
            methods: ["GET", "HEAD"],
            parameters: ["detail_location"],
        },
        "detail-location.edit": {
            uri: "/detail-location/{detail_location}/edit",
            methods: ["GET", "HEAD"],
            parameters: ["detail_location"],
        },
        "detail-location.update": {
            uri: "/detail-location/{detail_location}",
            methods: ["PUT", "PATCH"],
            parameters: ["detail_location"],
        },
        "detail-location.destroy": {
            uri: "/detail-location/{detail_location}",
            methods: ["DELETE"],
            parameters: ["detail_location"],
        },
        getSubLocations: {
            uri: "/get-sub-locations",
            methods: ["GET", "HEAD"],
        },
    },
};
if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
