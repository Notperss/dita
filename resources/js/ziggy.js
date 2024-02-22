const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"password.request":{"uri":"forgot-password","methods":["GET","HEAD"]},"password.reset":{"uri":"reset-password\/{token}","methods":["GET","HEAD"],"parameters":["token"]},"password.email":{"uri":"forgot-password","methods":["POST"]},"password.update":{"uri":"reset-password","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"user-profile-information.update":{"uri":"user\/profile-information","methods":["PUT"]},"user-password.update":{"uri":"user\/password","methods":["PUT"]},"password.confirmation":{"uri":"user\/confirmed-password-status","methods":["GET","HEAD"]},"password.confirm":{"uri":"user\/confirm-password","methods":["POST"]},"two-factor.login":{"uri":"two-factor-challenge","methods":["GET","HEAD"]},"two-factor.enable":{"uri":"user\/two-factor-authentication","methods":["POST"]},"two-factor.confirm":{"uri":"user\/confirmed-two-factor-authentication","methods":["POST"]},"two-factor.disable":{"uri":"user\/two-factor-authentication","methods":["DELETE"]},"two-factor.qr-code":{"uri":"user\/two-factor-qr-code","methods":["GET","HEAD"]},"two-factor.secret-key":{"uri":"user\/two-factor-secret-key","methods":["GET","HEAD"]},"two-factor.recovery-codes":{"uri":"user\/two-factor-recovery-codes","methods":["GET","HEAD"]},"profile.show":{"uri":"user\/profile","methods":["GET","HEAD"]},"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"livewire.update":{"uri":"livewire\/update","methods":["POST"]},"livewire.upload-file":{"uri":"livewire\/upload-file","methods":["POST"]},"livewire.preview-file":{"uri":"livewire\/preview-file\/{filename}","methods":["GET","HEAD"],"parameters":["filename"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"backsite.dashboard.index":{"uri":"backsite\/dashboard","methods":["GET","HEAD"]},"backsite.dashboard.create":{"uri":"backsite\/dashboard\/create","methods":["GET","HEAD"]},"backsite.dashboard.store":{"uri":"backsite\/dashboard","methods":["POST"]},"backsite.dashboard.show":{"uri":"backsite\/dashboard\/{dashboard}","methods":["GET","HEAD"],"parameters":["dashboard"]},"backsite.dashboard.edit":{"uri":"backsite\/dashboard\/{dashboard}\/edit","methods":["GET","HEAD"],"parameters":["dashboard"]},"backsite.dashboard.update":{"uri":"backsite\/dashboard\/{dashboard}","methods":["PUT","PATCH"],"parameters":["dashboard"]},"backsite.dashboard.destroy":{"uri":"backsite\/dashboard\/{dashboard}","methods":["DELETE"],"parameters":["dashboard"]},"backsite.main-location.index":{"uri":"backsite\/main-location","methods":["GET","HEAD"]},"backsite.main-location.create":{"uri":"backsite\/main-location\/create","methods":["GET","HEAD"]},"backsite.main-location.store":{"uri":"backsite\/main-location","methods":["POST"]},"backsite.main-location.show":{"uri":"backsite\/main-location\/{main_location}","methods":["GET","HEAD"],"parameters":["main_location"]},"backsite.main-location.edit":{"uri":"backsite\/main-location\/{main_location}\/edit","methods":["GET","HEAD"],"parameters":["main_location"]},"backsite.main-location.update":{"uri":"backsite\/main-location\/{main_location}","methods":["PUT","PATCH"],"parameters":["main_location"]},"backsite.main-location.destroy":{"uri":"backsite\/main-location\/{main_location}","methods":["DELETE"],"parameters":["main_location"]},"backsite.sub-location.index":{"uri":"backsite\/sub-location","methods":["GET","HEAD"]},"backsite.sub-location.create":{"uri":"backsite\/sub-location\/create","methods":["GET","HEAD"]},"backsite.sub-location.store":{"uri":"backsite\/sub-location","methods":["POST"]},"backsite.sub-location.show":{"uri":"backsite\/sub-location\/{sub_location}","methods":["GET","HEAD"],"parameters":["sub_location"]},"backsite.sub-location.edit":{"uri":"backsite\/sub-location\/{sub_location}\/edit","methods":["GET","HEAD"],"parameters":["sub_location"]},"backsite.sub-location.update":{"uri":"backsite\/sub-location\/{sub_location}","methods":["PUT","PATCH"],"parameters":["sub_location"]},"backsite.sub-location.destroy":{"uri":"backsite\/sub-location\/{sub_location}","methods":["DELETE"],"parameters":["sub_location"]},"backsite.detail-location.index":{"uri":"backsite\/detail-location","methods":["GET","HEAD"]},"backsite.detail-location.create":{"uri":"backsite\/detail-location\/create","methods":["GET","HEAD"]},"backsite.detail-location.store":{"uri":"backsite\/detail-location","methods":["POST"]},"backsite.detail-location.show":{"uri":"backsite\/detail-location\/{detail_location}","methods":["GET","HEAD"],"parameters":["detail_location"]},"backsite.detail-location.edit":{"uri":"backsite\/detail-location\/{detail_location}\/edit","methods":["GET","HEAD"],"parameters":["detail_location"]},"backsite.detail-location.update":{"uri":"backsite\/detail-location\/{detail_location}","methods":["PUT","PATCH"],"parameters":["detail_location"]},"backsite.detail-location.destroy":{"uri":"backsite\/detail-location\/{detail_location}","methods":["DELETE"],"parameters":["detail_location"]},"backsite.getSubLocations":{"uri":"backsite\/get-sub-locations","methods":["GET","HEAD"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
