ZENDVERSION=1.11.5

help-cs:
	@echo "Please use: (e.g. make cs-install)"
	@echo "     cs-install ............................ Install CodeSniffer"
	@echo "     cs-uninstall .......................... Uninstall CodeSniffer"
	@echo "     cs-install-submodule MPATH=<path> ..... Install CodeSniffer on a submodule,"
	@echo "                                             <path> must by the relative path to the submodule"
	@echo "     cs-uninstall-submodule MPATH=<path> ... Uninstall CodeSniffer on a submodule,"
	@echo "                                             <path> must by the relative path to the submodule"
	@echo "     cs-enable ............................. Enable CodeSniffer to check code before every commit"
	@echo "     cs-disable ............................ Disable CodeSniffer code checking"
	@echo "     cs-check-commit ....................... Run pre-commit code checking manually"
	@echo "     cs-check-commit-emacs ................. Same as cs-check-commit with emacs output"
	@echo "     cs-check-commit-intensive ............. Run pre-commit code checking"
	@echo "                                             manually with stricter coding standard"
	@echo "     cs-check .............................. Run complete code checking"
	@echo "     cs-check-full ......................... Run complete code checking with detailed output"
	@echo "     cs-check-emacs ........................ Run complete code checking with with emacs output"
	@echo "     cs-check-blame ........................ Run complete code checking with blame list output"
	@echo "     cs-check-intensive .................... Run complete code checking with"
	@echo "                                             stricter coding standard"
	@echo "     cs-check-intensive-full ............... Run complete code checking with"
	@echo "                                             stricter coding standard and detailed output"
	@echo "     possible Parameter:"
	@echo "     > CHECKPATH=<path> ................. Run code checking on specific relative path"
	@echo "     > SNIFFS=<sniff 1>,<sniff 2> ... Run code checking on specific sniffs"
	@echo "     > OPTIONS=<option> ............. Run code checking with specific CodeSniffer options"

# coding standard

# #### config ####
# cs-script path
CSSPATH = ../../application/tests/CodeSniffer/
# ignore pattern
IGNOREPATTERN = libraries,extensions/exconf/pclzip.lib.php,extensions/exconf/Archive.php,application/scripts,extensions/markdown/parser/markdown.php,extensions/queries/lib,extensions/queries/old

# Parameter check
ifndef CHECKPATH
	CHECKPATH = "./"
endif
ifdef SNIFFS
	SNIFFSTR = "--sniffs="$(SNIFFS)
else
	SNIFFSTR =
endif

REQUESTSTR = --ignore=$(IGNOREPATTERN) $(OPTIONS) $(SNIFFSTR)  $(CHECKPATH)

cs-default:
	chmod ugo+x "$(CSSPATH)cs-scripts.sh"

cs-install: cs-default
	$(CSSPATH)cs-scripts.sh -i

cs-install-submodule: cs-submodule-check cs-default
	$(CSSPATH)cs-scripts.sh -f $(CSSPATH) -m $(MPATH)

cs-uninstall-submodule: cs-submodule-check cs-default
	$(CSSPATH)cs-scripts.sh -n $(MPATH)

cs-uninstall: cs-default
	$(CSSPATH)cs-scripts.sh -u

cs-enable: cs-default
	$(CSSPATH)cs-scripts.sh -f $(CSSPATH) -e

cs-disable: cs-default
	$(CSSPATH)cs-scripts.sh -d

cs-check-commit:
	$(CSSPATH)cs-scripts.sh -p ""
cs-check-commit-emacs:
	$(CSSPATH)cs-scripts.sh -p "-remacs"
cs-check-commit-intensive:
	$(CSSPATH)cs-scripts.sh -p "-s"

cs-check:
	@$(CSSPATH)cs-scripts.sh -c "-s --report=summary $(REQUESTSTR)"
cs-check-intensive:
	@$(CSSPATH)cs-scripts.sh -s -c "-s --report=summary $(REQUESTSTR)"
cs-check-intensive-full:
	@$(CSSPATH)cs-scripts.sh -s -c "-s --report=full $(REQUESTSTR)"
cs-check-full:
	@$(CSSPATH)cs-scripts.sh -c "-s --report=full $(REQUESTSTR)"
cs-check-emacs:
	@$(CSSPATH)cs-scripts.sh -c "--report=emacs $(REQUESTSTR)"
cs-check-blame:
	@$(CSSPATH)cs-scripts.sh -c "--report=gitblame $(REQUESTSTR)"

cs-submodule-check:
ifndef MPATH
	@echo "You must Set a path to the submodule."
	@echo "Example: MPATH=path/to/the/submodule/"
	@exit 1
endif