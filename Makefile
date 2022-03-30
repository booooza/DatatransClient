generate:
	java -jar openapi-generator-cli.jar generate \
	    --generator-name php \
	    --input-spec spec/datatrans-openapi-specification-2.0.26.json \
	    --config config.yaml \
	    --git-user-id booooza \
	    --git-repo-id DatatransClient