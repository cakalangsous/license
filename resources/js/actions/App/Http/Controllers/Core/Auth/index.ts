import AuthenticatedSessionController from './AuthenticatedSessionController'
import PasswordResetLinkController from './PasswordResetLinkController'
import NewPasswordController from './NewPasswordController'
import TwoFactorChallengeController from './TwoFactorChallengeController'
const Auth = {
    AuthenticatedSessionController: Object.assign(AuthenticatedSessionController, AuthenticatedSessionController),
PasswordResetLinkController: Object.assign(PasswordResetLinkController, PasswordResetLinkController),
NewPasswordController: Object.assign(NewPasswordController, NewPasswordController),
TwoFactorChallengeController: Object.assign(TwoFactorChallengeController, TwoFactorChallengeController),
}

export default Auth