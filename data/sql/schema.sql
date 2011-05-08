CREATE TABLE public.cf_profiles (id BIGSERIAL, name TEXT, name_en TEXT, is_def_allowed BOOLEAN, PRIMARY KEY(id));
CREATE TABLE public.cf_rules (id BIGSERIAL, profile_id BIGINT, is_allowed BOOLEAN, type_id BIGINT, value TEXT, is_enabled BOOLEAN DEFAULT 'true', PRIMARY KEY(id));
CREATE TABLE public.cf_types (id BIGSERIAL, name TEXT, PRIMARY KEY(id));
CREATE TABLE public.identities (id BIGINT, name TEXT, description TEXT, is_enabled BOOLEAN DEFAULT 'true', is_inet_allowed BOOLEAN DEFAULT 'false', inet_channels_id BIGINT, profile_id BIGINT, auth_type BIGINT, PRIMARY KEY(id));
CREATE TABLE public.inet_channels (id BIGSERIAL, name TEXT, ip TEXT, gw TEXT, iface TEXT, PRIMARY KEY(id));
#CREATE TABLE public.work_places (id BIGINT, name TEXT, description TEXT, is_enabled BOOLEAN DEFAULT 'true', is_inet_allowed BOOLEAN DEFAULT 'false', inet_channels_id BIGINT, profile_id BIGINT, auth_type BIGINT, mac TEXT, ip TEXT, PRIMARY KEY(id));

