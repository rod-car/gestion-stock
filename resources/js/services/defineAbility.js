import { AbilityBuilder, Ability } from "@casl/ability";

export default function defineAbilityFor(userRole) {
  const { can, cannot, build } = new AbilityBuilder(Ability);

  if (userRole === 'user') {
    can ('read', 'Institution')
    cannot(['create', 'update'], 'all')
  }

  if (userRole === 'reg_admin_stroke' || userRole === 'admin') {
    can('manage', 'all')
  }

  return build()
}
