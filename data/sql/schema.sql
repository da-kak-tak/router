CREATE TABLE public.identities (id BIGSERIAL, name TEXT, description TEXT, is_enabled BOOLEAN, is_inet_allowed BOOLEAN DEFAULT 'true', inet_channels_id BIGINT, PRIMARY KEY(id));
CREATE TABLE public.inet_channels (id BIGSERIAL, name TEXT, ip TEXT, gw TEXT, iface TEXT, PRIMARY KEY(id));
CREATE TABLE public.work_places (id BIGSERIAL, name TEXT, description TEXT, is_enabled BOOLEAN, is_inet_allowed BOOLEAN DEFAULT 'true', inet_channels_id BIGINT, mac TEXT, ip TEXT, PRIMARY KEY(id));
ALTER TABLE public.identities ADD CONSTRAINT public_identities_inet_channels_id_public_inet_channels_id FOREIGN KEY (inet_channels_id) REFERENCES public.inet_channels(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE public.work_places ADD CONSTRAINT public_work_places_inet_channels_id_public_inet_channels_id FOREIGN KEY (inet_channels_id) REFERENCES public.inet_channels(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
