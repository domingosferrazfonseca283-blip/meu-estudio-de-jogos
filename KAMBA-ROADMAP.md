# Kamba CMS

Kamba is a modern content management platform built on the WordPress foundation, with its own administration experience and a growing set of first-party capabilities.

## Project principles
- Keep WordPress core separate from Kamba customisations.
- Build Kamba features as modular, documented plugins.
- Preserve compatibility with WordPress APIs and the GPL-2.0-or-later ecosystem.
- Prioritise security, accessibility, performance and maintainability.
- Do not remove WordPress credits or misrepresent the upstream foundation.

## Current foundation — Kamba Core 0.1.0
- Branded Kamba administration menu and dashboard.
- Original Kamba mark and visual system.
- Quick links to posts, pages, media and appearance.
- Capability checks and screen-scoped asset loading.
- No database schema changes; safe to activate and deactivate.

## Roadmap
1. Kamba Identity: configurable logo, colours and admin branding.
2. Kamba Dashboard: activity, content and site-health summaries.
3. Kamba Content: improved editorial workflow and content organisation.
4. Kamba Builder: accessible visual page-building experience.
5. Kamba Extensions: modular first-party extensions and integrations.
6. Kamba Security: role management, audit events and hardening.
7. Kamba Insights: privacy-conscious site analytics.

## Development
The Kamba Core plugin lives in wp-content/plugins/kamba-core/. Activate it from Plugins in the WordPress administration area. The Kamba dashboard then appears in the admin menu.

Kamba is not yet a standalone WordPress fork. This first milestone is an installable plugin layer, which makes the project easier to update and test without patching WordPress core.
