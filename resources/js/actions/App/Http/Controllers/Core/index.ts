import Auth from './Auth'
import ProductController from './ProductController'
import LicenseController from './LicenseController'
import ActivationController from './ActivationController'
import MarketplaceController from './MarketplaceController'
import SaleController from './SaleController'
import VerificationLogController from './VerificationLogController'
import BlacklistedDomainController from './BlacklistedDomainController'
import SidebarMenuController from './SidebarMenuController'
import DashboardController from './DashboardController'
import PostCategoryController from './PostCategoryController'
import TagController from './TagController'
import PostController from './PostController'
import UserController from './UserController'
import RoleController from './RoleController'
import PermissionController from './PermissionController'
import AccessController from './AccessController'
import UploadController from './UploadController'
import Crud from './Crud'
import ActivityLogController from './ActivityLogController'
import SystemHealthController from './SystemHealthController'
import BackupController from './BackupController'
import NotificationController from './NotificationController'
import SettingsController from './SettingsController'
import ApiTokenController from './ApiTokenController'
import ProfileController from './ProfileController'
import MediaController from './MediaController'
import TwoFactorController from './TwoFactorController'
const Core = {
    Auth: Object.assign(Auth, Auth),
ProductController: Object.assign(ProductController, ProductController),
LicenseController: Object.assign(LicenseController, LicenseController),
ActivationController: Object.assign(ActivationController, ActivationController),
MarketplaceController: Object.assign(MarketplaceController, MarketplaceController),
SaleController: Object.assign(SaleController, SaleController),
VerificationLogController: Object.assign(VerificationLogController, VerificationLogController),
BlacklistedDomainController: Object.assign(BlacklistedDomainController, BlacklistedDomainController),
SidebarMenuController: Object.assign(SidebarMenuController, SidebarMenuController),
DashboardController: Object.assign(DashboardController, DashboardController),
PostCategoryController: Object.assign(PostCategoryController, PostCategoryController),
TagController: Object.assign(TagController, TagController),
PostController: Object.assign(PostController, PostController),
UserController: Object.assign(UserController, UserController),
RoleController: Object.assign(RoleController, RoleController),
PermissionController: Object.assign(PermissionController, PermissionController),
AccessController: Object.assign(AccessController, AccessController),
UploadController: Object.assign(UploadController, UploadController),
Crud: Object.assign(Crud, Crud),
ActivityLogController: Object.assign(ActivityLogController, ActivityLogController),
SystemHealthController: Object.assign(SystemHealthController, SystemHealthController),
BackupController: Object.assign(BackupController, BackupController),
NotificationController: Object.assign(NotificationController, NotificationController),
SettingsController: Object.assign(SettingsController, SettingsController),
ApiTokenController: Object.assign(ApiTokenController, ApiTokenController),
ProfileController: Object.assign(ProfileController, ProfileController),
MediaController: Object.assign(MediaController, MediaController),
TwoFactorController: Object.assign(TwoFactorController, TwoFactorController),
}

export default Core