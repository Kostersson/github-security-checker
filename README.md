# github-security-checker

[![Code Climate](https://codeclimate.com/github/Kostersson/github-security-checker/badges/gpa.svg)](https://codeclimate.com/github/Kostersson/github-security-checker)

This tool checks organization's repositories with [sensiolabs/security-checker](https://github.com/sensiolabs/security-checker), and informs reported vulnerabilities to slack (or wherever you want).

- [Vulnerability alert handlers](src/AlertHandler)
- [Outgoing messages](src/Message)
- Inject our own handler and messaging interface in [config/services.yml](config/services.yml)
